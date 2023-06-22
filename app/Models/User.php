<?php

namespace App\Models;

use App\Notifications\VerifyUserNotification;
use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasFactory;

    public $table = 'users';

    public const TENANT_HIERARCHY = [
        'tenant_auto_planner' => 1,
        'tenant_branch_manager' => 2,
        'tenant_area_manager' => 3,
        'tenant_marketing_head' => 4,
    ];

    protected $appends = [
        'tenants',
        'tenant_head',
        'tenant_ids',
        'tenant_parent_ids',
        'tenant_level'
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'approved',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }


    public function getIsAdminAttribute(): bool
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getTenantsAttribute()
    {
        $tenantChild = [];
        $tenantParent = [];
        $tenantChildUser = [];
        $tenantParentUser = [];

        foreach (self::TENANT_HIERARCHY as $index => $item) {
            if (isset(self::TENANT_HIERARCHY[$this->getTenantLevelAttribute()])) {
                if (self::TENANT_HIERARCHY[$this->getTenantLevelAttribute()] > $item) {
                    $tenantChild[] = $index;
                } else {
                    $tenantParent[] = $index;
                }
            }
        }

        if ($this->getTenantLevelAttribute() == 'tenant_auto_planner') {
            $tenantChild[] = 'tenant_auto_planner';
        }

        $onTenant = Tenant::with('user')->where('user_id', Auth::id())->first();
        if ($onTenant) {
            $tenants = Tenant::with('team', 'user')->where('team_id', $onTenant->team_id)->get();

            foreach ($tenants as $tenant) {
                $tenant->user->load('roles');
                foreach ($tenantChild as $item) {
                    foreach ($tenant->user->roles as $role) {
                        $role = Role::with('permissions')
                            ->where('id', $role->id)
                            ->whereRelation('permissions', 'title', $item)->first();

                        if ($role) {
                            $tenantChildUser[$tenant->user->id] = $tenant->user;
                        }
                    }
                }

                foreach ($tenantParent as $parent) {
                    foreach ($tenant->user->roles as $role) {
                        $role = Role::with('permissions')
                            ->where('id', $role->id)
                            ->whereRelation('permissions', 'title', $parent)->first();

                        if ($role) {
                            $tenantParentUser[$tenant->user->id] = $tenant->user;
                        }
                    }
                }
            }
        }

        return [$tenantChildUser, $tenantParentUser];
    }

    public function getTenantHeadAttribute() {
        $currentIsTeamHead = Team::with('owner')->where('owner_id', Auth::id())->first();
        if ($currentIsTeamHead) {
            return Tenant::with('user', 'team')->where('team_id', $currentIsTeamHead->id)
                ->get()->pluck('user_id')->toArray();
        }

        return [];
    }

    public function getTenantIdsAttribute(): array
    {
        $tenants = $this->getTenantsAttribute()[0];
        $tenantIds = [];
        foreach ($tenants as $index => $item) {
            $tenantIds[] = $index;
        }
        return $tenantIds;
    }
    public function getTenantParentIdsAttribute(): array
    {
        $tenants = $this->getTenantsAttribute()[1];
        $tenantParentIds = [];
        foreach ($tenants as $index => $item) {
            $tenantParentIds[] = $index;
        }
        return $tenantParentIds;
    }

    public function getTenantLevelAttribute(): ?string
    {
        return Gate::allows('tenant_auto_planner') ? 'tenant_auto_planner' :
            (Gate::allows('tenant_branch_manager') ? 'tenant_branch_manager' :
                (Gate::allows('tenant_area_manager') ? 'tenant_area_manager' :
                    (Gate::allows('tenant_marketing_head') ? 'tenant_marketing_head' : null)));
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (self $user) {
            $registrationRole = config('panel.registration_default_role');
            if (!$user->roles()->get()->contains($registrationRole)) {
                $user->roles()->attach($registrationRole);
            }
        });
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
