@php
$c = Request::segment(1);
$m = Request::segment(2);
$roleName = Auth::user()->getRoleNames();
@endphp

<aside class="main-sidebar sidebar-light-info elevation-4">
    <a href="{{ route('dashboard')  }}" class="brand-link sidebar-light-info">
        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $ApplicationSetting->item_name }}" id="custom-opacity-sidebar" class="brand-image">
        <!-- <span class="brand-text font-weight-light">{{ $ApplicationSetting->item_name }}</span> -->
        <div class="logo-container">
            <img src="{{ asset('assets/images/ovi_logo_gradient_ch_black.png') }}" alt="Logo">
        </div>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if($c == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>

                @canany(['hospital-department-read', 'hospital-department-create', 'hospital-department-update', 'hospital-department-delete'])
                    <li class="nav-item">
                        <a href="{{ route('hospital-departments.index') }}" class="nav-link @if($c == 'hospital-departments') active @endif">
                            <i class="nav-icon fas fa-bezier-curve"></i>
                            <p>@lang('Manage Departments')</p>
                        </a>
                    </li>
                @endcanany
                @canany(['doctor-detail-read', 'doctor-detail-create', 'doctor-detail-update', 'doctor-detail-delete'])
                    <li class="nav-item">
                        <a href="{{ route('doctor-details.index') }}" class="nav-link @if($c == 'doctor-details') active @endif">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>@lang('Manage Doctors')</p>
                        </a>
                    </li>
                @endcanany
                @canany(['patient-detail-read', 'patient-detail-create', 'patient-detail-update', 'patient-detail-delete'])
                    <li class="nav-item">
                        <a href="{{ route('patient-details.index') }}" class="nav-link @if($c == 'patient-details') active @endif">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>@lang('Manage Patients')</p>
                        </a>
                    </li>
                @endcanany
                @canany(['doctor-assignment-read', 'doctor-assignment-create', 'doctor-assignment-update', 'doctor-assignment-delete'])
                    <li class="nav-item">
                        <a href="{{ route('doctor-assignments.index') }}" class="nav-link @if($c == 'doctor-assignments') active @endif">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Doctor Assignments</p>
                        </a>
                    </li>
                @endcanany
                @canany(['ward-read'])
                <li class="nav-item">
                    <a href="{{ route('wards.index') }}" class="nav-link @if($c == 'wards') active @endif">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>{{ __('Wards') }}</p>
                    </a>
                </li>
                @endcanany
                @can('drug-orders-read')
                    <li class="nav-item">
                        <a href="{{ route('drug-orders.index') }}" class="nav-link @if($c == 'drug-orders') active @endif">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Drug Orders</p>
                        </a>
                    </li>
                @endcan
                @php
                    $clinical_routes = ['cvi', 'initial-evaluations', 'care-plans', 'lab-requests', 'lab-reports', 'ward-round-notes', 'caregiver-daily-reports', 'therapy-reports', 'individual-therapy', 'group-therapy', 'weekly-wellness-checks', 'medical-referrals', 'radiology-requests', 'nursing-cardexes'];
                @endphp
                @canany(['cvi-read', 'initial-evaluations-read', 'care-plans-read', 'lab-requests-read', 'lab-reports-read', 'ward-round-notes-read', 'caregiver-daily-reports-read', 'therapy-reports-read', 'weekly-wellness-checks-read', 'ward-read', 'medical-referrals-read', 'radiology-requests-read', 'nursing-cardexes-read'])
                    <li class="nav-item has-treeview @if(in_array($c, $clinical_routes)) menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if(in_array($c, $clinical_routes)) active @endif">
                            <i class="nav-icon fas fa-heartbeat"></i>
                            <p>
                                {{ __('Clinical Reports') }}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['cvi-read'])
                            <li class="nav-item">
                                <a href="{{ route('cvi.index') }}" class="nav-link @if($c == 'cvi') active @endif">
                                    <i class="nav-icon fas fa-child"></i>
                                    <p>{{ __('Child Vitality Index') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['initial-evaluations-read'])
                            <li class="nav-item">
                                <a href="{{ route('initial-evaluations.index') }}" class="nav-link @if($c == 'initial-evaluations') active @endif">
                                    <i class="nav-icon fas fa-file-medical-alt"></i>
                                    <p>{{ __('Initial Evaluation') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['care-plans-read'])
                            <li class="nav-item">
                                <a href="{{ route('care-plans.index') }}" class="nav-link @if($c == 'care-plans') active @endif">
                                    <i class="nav-icon fas fa-notes-medical"></i>
                                    <p>{{ __('Care Plan') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['lab-requests-read'])
                            <li class="nav-item">
                                <a href="{{ route('lab-requests.index') }}" class="nav-link @if($c == 'lab-requests') active @endif">
                                    <i class="nav-icon fas fa-prescription-bottle-alt"></i>
                                    <p>{{ __('Lab Request') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['lab-reports-read'])
                            <li class="nav-item">
                                <a href="{{ route('lab-reports.index') }}" class="nav-link @if($c == 'lab-reports' && $m == null) active @endif">
                                    <i class="nav-icon fas fa-vial"></i>
                                    <p>{{ __('Lab Report') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['ward-round-notes-read'])
                            <li class="nav-item">
                                <a href="{{ route('ward-round-notes.index') }}" class="nav-link @if($c == 'ward-round-notes') active @endif">
                                    <i class="nav-icon fas fa-walking"></i>
                                    <p>{{ __('Ward Round Notes') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['caregiver-daily-reports-read'])
                            <li class="nav-item">
                                <a href="{{ route('caregiver-daily-reports.index') }}" class="nav-link @if($c == 'caregiver-daily-reports') active @endif">
                                    <i class="nav-icon fas fa-user-nurse"></i>
                                    <p>{{ __('Caregiver Daily Report') }}</p>
                                </a>
                            </li>
                            @endcanany
                            @canany(['therapy-reports-read', 'therapy-reports-create'])
                            <li class="nav-item has-treeview @if(in_array($c, ['therapy-reports', 'individual-therapy', 'group-therapy'])) menu-open @endif">
                                <a href="javascript:void(0)" class="nav-link @if(in_array($c, ['therapy-reports', 'individual-therapy', 'group-therapy'])) active @endif">
                                    <i class="nav-icon fas fa-hand-holding-heart"></i>
                                    <p>
                                        {{ __('Therapy Report') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('therapy-reports-read')
                                    <li class="nav-item">
                                        <a href="{{ route('therapy-reports.individual') }}" class="nav-link @if(request()->routeIs('therapy-reports.individual')) active @endif">
                                            <i class="nav-icon fas fa-list"></i>
                                            <p>{{ __('Individual Reports') }}</p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('therapy-reports-read')
                                    <li class="nav-item">
                                        <a href="{{ route('therapy-reports.group') }}" class="nav-link @if(request()->routeIs('therapy-reports.group')) active @endif">
                                            <i class="nav-icon fas fa-list-alt"></i>
                                            <p>{{ __('Group Reports') }}</p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('therapy-reports-create')
                                    <li class="nav-item">
                                        <a href="{{ route('individual-therapy.create') }}" class="nav-link @if(request()->routeIs('individual-therapy.create')) active @endif">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p>{{ __('Add Individual') }}</p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('therapy-reports-create')
                                    <li class="nav-item">
                                        <a href="{{ route('group-therapy.create') }}" class="nav-link @if(request()->routeIs('group-therapy.create')) active @endif">
                                            <i class="nav-icon fas fa-plus-square"></i>
                                            <p>{{ __('Add Group') }}</p>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcanany
                            @canany(['weekly-wellness-checks-read'])
                            <li class="nav-item has-treeview @if($c == 'weekly-wellness-checks') menu-open @endif">
                                <a href="javascript:void(0)" class="nav-link @if($c == 'weekly-wellness-checks') active @endif">
                                    <i class="nav-icon fas fa-calendar-check"></i>
                                    <p>
                                        {{ __('Weekly Wellness Check') }}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('weekly-wellness-checks.index') }}" class="nav-link @if($c == 'weekly-wellness-checks' && $m == null) active @endif">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>{{ __('All Checks') }}</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('weekly-wellness-checks.report') }}" class="nav-link @if($c == 'weekly-wellness-checks' && $m == 'report') active @endif">
                                            <i class="fas fa-chart-bar nav-icon"></i>
                                            <p>{{ __('Weekly Report') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endcanany
                            @can('medical-referrals-read')
                                <li class="nav-item">
                                    <a href="{{ route('medical-referrals.index') }}" class="nav-link @if($c == 'medical-referrals') active @endif">
                                        <i class="nav-icon fas fa-file-medical"></i>
                                        <p>Medical Referrals</p>
                                    </a>
                                </li>
                            @endcan
                            @can('radiology-requests-read')
                                <li class="nav-item">
                                    <a href="{{ route('radiology-requests.index') }}" class="nav-link @if($c == 'radiology-requests') active @endif">
                                        <i class="nav-icon fas fa-x-ray"></i>
                                        <p>Radiology Requests</p>
                                    </a>
                                </li>
                            @endcan
                            @can('nursing-cardexes-read')
                                <li class="nav-item">
                                    <a href="{{ route('nursing-cardexes.index') }}" class="nav-link @if($c == 'nursing-cardexes') active @endif">
                                        <i class="nav-icon fas fa-address-card"></i>
                                        <p>Nursing Cardex</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                
                <!-- Clinical Leaderboard as Independent Menu Item -->
                @can('clinical-leaderboard-read')
                    <li class="nav-item">
                        <a href="{{ route('clinical-leaderboard.index') }}" class="nav-link @if($c == 'clinical-leaderboard') active @endif">
                            <i class="nav-icon fas fa-trophy"></i>
                            <p>@lang('Clinical Leaderboard')</p>
                        </a>
                    </li>
                @endcan
                @canany(['prescription-read', 'prescription-create', 'prescription-update', 'prescription-delete'])
                    <li class="nav-item">
                        <a href="{{ route('prescriptions.index') }}" class="nav-link @if($c == 'prescriptions') active @endif">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>@lang('Prescription')</p>
                        </a>
                    </li>
                @endcanany
                
                <!-- Vital Signs Management -->
                @canany(['vital-signs-read', 'vital-signs-create', 'vital-signs-update', 'vital-signs-delete'])
                    <li class="nav-item">
                        <a href="{{ route('vital-signs.index') }}" class="nav-link @if($c == 'vital-signs') active @endif">
                            <i class="nav-icon fas fa-heartbeat"></i>
                            <p>{{ __('Vital Signs Configuration') }}</p>
                        </a>
                    </li>
                @endcanany


                @canany(['lab-report-read', 'lab-report-create', 'lab-report-update', 'lab-report-delete', 'lab-report-template-read', 'lab-report-template-create', 'lab-report-template-update', 'lab-report-template-delete'])
                    <li class="nav-item has-treeview @if($c == 'lab-reports' || $c == 'lab-report-templates') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if($c == 'lab-reports' || $c == 'lab-report-templates') active @endif">
                            <i class="nav-icon fas fa-flask"></i>
                            <p>
                                @lang('Manage Lab')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['lab-report-read', 'lab-report-create', 'lab-report-update', 'lab-report-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('lab-reports.index') }}" class="nav-link @if($c == 'lab-reports') active @endif">
                                        <i class="nav-icon fas fa-vial"></i>
                                        <p>@lang('Lab Report')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['lab-report-template-read', 'lab-report-template-create', 'lab-report-template-update', 'lab-report-template-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('lab-report-templates.index') }}" class="nav-link @if($c == 'lab-report-templates') active @endif">
                                        <i class="nav-icon fas fa-crop-alt"></i>
                                        <p>@lang('Lab Report Templates')</p>
                                    </a>
                                </li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany

                @canany(['role-read', 'role-create', 'role-update', 'role-delete', 'user-read', 'user-create', 'user-update', 'user-delete', 'smtp-read', 'smtp-create', 'smtp-update', 'smtp-delete','company-read', 'company-create', 'company-update', 'company-delete'])
                    <li class="nav-item has-treeview @if($c == 'roles' || $c == 'users' || $c == 'apsetting' || $c == 'smtp-configurations' || $c == 'general' || $c == 'hikvision') menu-open @endif">
                        <a href="javascript:void(0)" class="nav-link @if($c == 'roles' || $c == 'users' || $c == 'apsetting' || $c == 'smtp-configurations' || $c == 'general' || $c == 'hikvision') active @endif">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                                @lang('Settings')
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @canany(['role-read', 'role-create', 'role-update', 'role-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link @if($c == 'roles') active @endif ">
                                        <i class="fas fa-cube nav-icon"></i>
                                        <p>@lang('Role Management')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['user-read', 'user-create', 'user-update', 'user-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link @if($c == 'users') active @endif ">
                                        <i class="fa fa-users nav-icon"></i>
                                        <p>@lang('User Management')</p>
                                    </a>
                                </li>
                            @endcanany
                            @if (in_array('Super Admin', $roleName->toArray()))
                                <li class="nav-item">
                                    <a href="{{ route('apsetting') }}" class="nav-link @if($c == 'apsetting' && $m == null) active @endif ">
                                        <i class="fa fa-globe nav-icon"></i>
                                        <p>@lang('Application Settings')</p>
                                    </a>
                                </li>
                            @endif
                            @canany(['company-read', 'company-create', 'company-update', 'company-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('general') }}" class="nav-link @if($c == 'general') active @endif ">
                                        <i class="fas fa-align-left nav-icon"></i>
                                        <p>@lang('General Settings')</p>
                                    </a>
                                </li>
                            @endcanany
                            @canany(['company-read', 'company-create', 'company-update', 'company-delete'])
                                <li class="nav-item">
                                    <a href="{{ route('hikvision.index') }}" class="nav-link @if($c == 'hikvision') active @endif ">
                                        <i class="fas fa-fingerprint nav-icon"></i>
                                        <p>@lang('Hikvision Settings')</p>
                                    </a>
                                </li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany
            </ul>
        </nav>
    </div>
</aside>
