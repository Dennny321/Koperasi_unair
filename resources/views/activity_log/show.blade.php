@extends('layouts.app')

@section('title', 'Detail Log Aktivitas')
@section('breadcrumb', 'Sistem / Log Aktivitas / Detail')
@section('page-title', 'Detail Log Aktivitas')

@section('content')
<div class="content-header">
    <div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Detail Log #{{ $log->id }} 🔍</h2>
        <p style="color: var(--text-secondary);">Informasi lengkap aktivitas</p>
    </div>
    <a href="{{ route('admin.activity-log.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px;">

    {{-- Kartu ringkasan --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ringkasan</h3>
        </div>
        <div style="padding: 24px; text-align: center;">

            {{-- Ikon aksi besar --}}
            <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 20px;
                        display: flex; align-items: center; justify-content: center;
                        background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                <i class="fas {{ $log->action_icon }}" style="font-size: 42px; color: white;"></i>
            </div>

            <span class="badge {{ $log->action_badge }}" style="padding: 8px 20px; font-size: 15px; margin-bottom: 16px; display: inline-block;">
                {{ $log->action_label }}
            </span>

            <div style="font-size: 22px; font-weight: 800; color: var(--primary); margin-bottom: 4px;">
                {{ $log->module }}
            </div>
            @if($log->subject_label)
                <div style="color: var(--text-secondary); font-size: 14px; margin-bottom: 20px;">
                    {{ $log->subject_label }}
                </div>
            @endif

            <div style="background: var(--bg-body); border-radius: 10px; padding: 16px; text-align: left;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: var(--text-secondary); font-size: 13px;">Waktu</span>
                    <span style="font-weight: 600; font-size: 13px;">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                    <span style="color: var(--text-secondary); font-size: 13px;">Sejak</span>
                    <span style="font-weight: 600; font-size: 13px;">{{ $log->created_at->diffForHumans() }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--text-secondary); font-size: 13px;">Bisa Dihapus</span>
                    <span style="font-weight: 600; font-size: 13px; color: {{ $log->can_be_deleted ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $log->can_be_deleted ? 'Ya' : 'Belum (< 3 bulan)' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail lengkap --}}
    <div style="display: flex; flex-direction: column; gap: 24px;">

        {{-- Info User & Request --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi User & Request</h3>
            </div>
            <div style="padding: 24px;">
                <table style="width: 100%; border-collapse: collapse;">
                    @php
                        $rows = [
                            ['icon' => 'fa-user',         'label' => 'Nama User',    'value' => $log->user_name ?? '-'],
                            ['icon' => 'fa-id-badge',     'label' => 'Role',         'value' => $log->user_role ?? '-'],
                            ['icon' => 'fa-link',         'label' => 'URL',          'value' => $log->url ?? '-'],
                            ['icon' => 'fa-code',         'label' => 'Method',       'value' => $log->method ?? '-'],
                            ['icon' => 'fa-globe',        'label' => 'IP Address',   'value' => $log->ip_address ?? '-'],
                            ['icon' => 'fa-browser',      'label' => 'User Agent',   'value' => $log->user_agent ?? '-'],
                        ];
                    @endphp
                    @foreach($rows as $i => $row)
                    <tr style="{{ $i < count($rows)-1 ? 'border-bottom: 1px solid var(--border-color);' : '' }}">
                        <td style="padding: 14px 0; width: 180px; font-weight: 600; color: var(--text-secondary); font-size: 13px;">
                            <i class="fas {{ $row['icon'] }}" style="margin-right: 8px; color: var(--primary);"></i>
                            {{ $row['label'] }}
                        </td>
                        <td style="padding: 14px 0; color: var(--text-main); font-size: 13px; word-break: break-all;">
                            {{ $row['value'] }}
                        </td>
                    </tr>
                    @endforeach
                </table>

                @if($log->description)
                <div style="margin-top: 20px; padding: 16px; background: var(--bg-body); border-radius: 10px; border-left: 4px solid var(--primary);">
                    <div style="font-size: 12px; font-weight: 700; color: var(--primary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Deskripsi</div>
                    <div style="font-size: 14px; color: var(--text-main);">{{ $log->description }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Data Perubahan --}}
        @if($log->old_values || $log->new_values)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Perubahan</h3>
            </div>
            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                    {{-- Data Lama --}}
                    @if($log->old_values)
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: var(--danger); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                            <i class="fas fa-minus-circle"></i> Data Sebelum
                        </div>
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; overflow: hidden;">
                            @foreach($log->old_values as $key => $value)
                                @if(!in_array($key, ['password', 'remember_token']))
                                <div style="display: flex; padding: 10px 14px; border-bottom: 1px solid #fecaca; font-size: 12px;">
                                    <span style="width: 130px; font-weight: 600; color: #991b1b; flex-shrink: 0;">{{ $key }}</span>
                                    <span style="color: #7f1d1d; word-break: break-all;">{{ is_array($value) ? json_encode($value) : ($value ?? 'null') }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Data Baru --}}
                    @if($log->new_values)
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: var(--success); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                            <i class="fas fa-plus-circle"></i> Data Sesudah
                        </div>
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; overflow: hidden;">
                            @foreach($log->new_values as $key => $value)
                                @if(!in_array($key, ['password', 'remember_token']))
                                <div style="display: flex; padding: 10px 14px; border-bottom: 1px solid #bbf7d0; font-size: 12px;">
                                    <span style="width: 130px; font-weight: 600; color: #166534; flex-shrink: 0;">{{ $key }}</span>
                                    <span style="color: #14532d; word-break: break-all;">{{ is_array($value) ? json_encode($value) : ($value ?? 'null') }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endif

    </div>{{-- end right column --}}
</div>
@endsection
