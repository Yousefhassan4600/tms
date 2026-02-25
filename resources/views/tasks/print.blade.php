<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أعتماد الموافقة #{{ $task->id }}</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        @page { size: A4; margin: 10mm; }

        body {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
            line-height: 1.5;
            direction: rtl;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .page {
            width: 210mm;
            height: 277mm; /* A4 minus margins = fits exactly one page */
            margin: 10px auto;
            background: #ffffff;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        @media print {
            body { background: #fff; }
            .page {
                width: 100%; height: auto; max-height: 277mm;
                box-shadow: none; border-radius: 0; margin: 0;
            }
            .no-print { display: none !important; }
        }

        /* ── Header ──────────────────────────────────── */
        .header {
            background: linear-gradient(135deg, #1e3a5f 0%, #0d47a1 50%, #1565c0 100%);
            color: #fff;
            padding: 18px 30px;
            flex-shrink: 0;
        }
        .header-content {
            display: flex; justify-content: space-between; align-items: center;
        }
        .header-title h1 { font-size: 22px; font-weight: 700; margin-bottom: 2px; }
        .header-title p { font-size: 12px; opacity: 0.85; }
        .header-badge {
            background: rgba(255,255,255,0.25);
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 10px;
            padding: 8px 18px; text-align: center;
            flex-shrink: 0; min-width: 80px;
        }
        .header-badge .task-number { font-size: 24px; font-weight: 800; display: block; line-height: 1.2; color: #fff; }
        .header-badge .task-label { font-size: 10px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9; }

        /* Print-specific badge fix */
        @media print {
            .header-badge {
                background: #1565c0 !important;
                border-color: #fff !important;
            }
        }

        /* ── Content ─────────────────────────────────── */
        .content { padding: 18px 30px; flex: 1; }

        /* ── Status Banner ────────────────────────────── */
        .status-banner {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; border-radius: 8px;
            margin-bottom: 16px; border: 1px solid;
        }
        .status-banner.status-new { background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-color: #90caf9; color: #0d47a1; }
        .status-banner.status-reviewed { background: linear-gradient(135deg, #fff3e0, #ffe0b2); border-color: #ffcc80; color: #e65100; }
        .status-banner.status-holding { background: linear-gradient(135deg, #fce4ec, #f8bbd0); border-color: #f48fb1; color: #880e4f; }
        .status-banner.status-approved { background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-color: #a5d6a7; color: #1b5e20; }
        .status-banner.status-rejected { background: linear-gradient(135deg, #ffebee, #ffcdd2); border-color: #ef9a9a; color: #b71c1c; }

        .status-icon {
            width: 34px; height: 34px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .status-banner.status-new .status-icon { background: #1565c0; color: #fff; }
        .status-banner.status-reviewed .status-icon { background: #ef6c00; color: #fff; }
        .status-banner.status-holding .status-icon { background: #ad1457; color: #fff; }
        .status-banner.status-approved .status-icon { background: #2e7d32; color: #fff; }
        .status-banner.status-rejected .status-icon { background: #c62828; color: #fff; }

        .status-text h3 { font-size: 14px; font-weight: 700; }
        .status-text p { font-size: 11px; opacity: 0.8; }

        /* ── Section ──────────────────────────────────── */
        .section { margin-bottom: 14px; }
        .section-title {
            font-size: 13px; font-weight: 700; color: #0d47a1;
            padding-bottom: 6px; margin-bottom: 8px;
            border-bottom: 2px solid #e3f2fd;
            display: flex; align-items: center; gap: 6px;
        }
        .section-title::before {
            content: ''; width: 3px; height: 16px;
            background: linear-gradient(180deg, #0d47a1, #1976d2);
            border-radius: 2px; display: inline-block;
        }

        /* ── Detail Grid ─────────────────────────────── */
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }
        .detail-item {
            padding: 8px 14px; border-bottom: 1px solid #f0f2f5;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .detail-item:nth-child(odd) { border-left: 1px solid #f0f2f5; }

        .detail-label {
            font-size: 11px; font-weight: 600; color: #64748b;
            letter-spacing: 0.3px; min-width: 85px; flex-shrink: 0;
        }
        .detail-value { font-size: 13px; font-weight: 500; color: #1e293b; word-break: break-word; }
        .detail-value.empty { color: #94a3b8; font-style: italic; }

        /* ── Description Box ─────────────────────────── */
        .desc-box {
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 8px; padding: 12px 16px;
            font-size: 13px; line-height: 1.7; color: #334155;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            overflow: hidden;
        }
        .desc-box ul, .desc-box ol { padding-right: 25px; margin: 10px 0; }
        .desc-box li { margin-bottom: 5px; }
        .desc-box p { margin-bottom: 10px; word-wrap: break-word; overflow-wrap: break-word; }
        .desc-box a { color: #0d47a1; text-decoration: underline; word-break: break-all; }
        .desc-box img { max-width: 100%; height: auto; border-radius: 4px; }
        .desc-box * { word-wrap: break-word; overflow-wrap: break-word; white-space: normal; }

        /* ── File Attachment ──────────────────────────── */
        .file-attachment {
            display: flex; align-items: center; gap: 10px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-radius: 8px; padding: 8px 14px;
        }
        .file-icon {
            width: 30px; height: 30px; background: #16a34a; color: #fff;
            border-radius: 6px; display: flex; align-items: center;
            justify-content: center; font-size: 14px; flex-shrink: 0;
        }
        .file-info { font-size: 12px; color: #166534; font-weight: 600; }
        .no-file { display: flex; align-items: center; gap: 8px; color: #94a3b8; font-size: 12px; font-style: italic; }

        /* ── Reject Reason Box ────────────────────────── */
        .reject-box {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 8px; padding: 10px 16px;
            color: #991b1b; font-size: 12px; line-height: 1.6;
        }
        .reject-box strong { display: block; margin-bottom: 2px; font-size: 11px; color: #b91c1c; }

        /* ── Bottom Section (Signatures + Footer) ───── */
        .bottom-section {
            padding: 10px 30px 14px;
            flex-shrink: 0;
            border-top: 2px solid #e2e8f0;
            background: #f8fafc;
        }
        .signatures {
            display: flex; gap: 60px;
        }
        .signature-block { flex: 1; text-align: center; }
        .signature-line {
            border-top: 2px solid #cbd5e1;
            margin-top: 40px; padding-top: 6px;
            font-size: 12px; color: #64748b; font-weight: 600;
        }
        .footer-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 12px; padding-top: 8px;
            border-top: 1px solid #e2e8f0;
        }
        .footer-text { font-size: 11px; color: #94a3b8; }

        /* ── Print Buttons ────────────────────────────── */
        .print-actions {
            position: fixed; bottom: 20px; left: 50%;
            transform: translateX(-50%);
            display: flex; gap: 10px; z-index: 100;
        }
        .btn {
            padding: 10px 24px; border: none; border-radius: 8px;
            font-size: 14px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .btn-print { background: linear-gradient(135deg, #0d47a1, #1976d2); color: #fff; }
        .btn-print:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(13,71,161,0.4); }
        .btn-close { background: #fff; color: #64748b; border: 1px solid #e2e8f0; }
        .btn-close:hover { background: #f1f5f9; transform: translateY(-2px); }
    </style>
</head>
<body>

    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="header-title">
                    <h1>أعتماد الموافقة</h1>
                    <p>تم إنشاء هذا التقرير بتاريخ {{ now()->format('d/m/Y h:i A') }}</p>
                </div>
                <div class="header-badge">
                    <span class="task-number">#{{ $task->id }}</span>
                    <span class="task-label">رقم المهمة</span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">

            <!-- Status Banner -->
            @php
                $statusClass = match($task->status) {
                    \App\Enums\TaskStatus::New => 'status-new',
                    \App\Enums\TaskStatus::Reviewed => 'status-reviewed',
                    \App\Enums\TaskStatus::Holding => 'status-holding',
                    \App\Enums\TaskStatus::Approved => 'status-approved',
                    \App\Enums\TaskStatus::Rejected => 'status-rejected',
                    default => 'status-new',
                };
                $statusIcon = match($task->status) {
                    \App\Enums\TaskStatus::New => '●',
                    \App\Enums\TaskStatus::Reviewed => '◉',
                    \App\Enums\TaskStatus::Holding => '◷',
                    \App\Enums\TaskStatus::Approved => '✓',
                    \App\Enums\TaskStatus::Rejected => '✕',
                    default => '●',
                };
            @endphp
            <div class="status-banner {{ $statusClass }}">
                <div class="status-icon">{{ $statusIcon }}</div>
                <div class="status-text">
                    <h3>{{ $task->status->label() }}</h3>
                    <p>الحالة الحالية للمهمة</p>
                </div>
            </div>

            <!-- Task Description -->
            <div class="section">
                <div class="section-title">وصف المهمة</div>
                <div class="desc-box">
                    {!! $task->desc ?? 'لا يوجد وصف' !!}
                </div>
            </div>

            <!-- Task Details Grid -->
            <div class="section">
                <div class="section-title">تفاصيل المهمة</div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">رقم المهمة</span>
                        <span class="detail-value">#{{ $task->id }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">التصنيف</span>
                        <span class="detail-value">{{ $task->taskCategory?->name ?? '—' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المستخدم</span>
                        <span class="detail-value">{{ $task->user?->name ?? '—' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">الحالة</span>
                        <span class="detail-value">{{ $task->status->label() }}</span>
                    </div>
                </div>
            </div>

            <!-- Dates Section -->
            <div class="section">
                <div class="section-title">التواريخ</div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">تاريخ الإنشاء</span>
                        <span class="detail-value">{{ $task->created_at?->format('d/m/Y h:i A') ?? '—' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ التحديث</span>
                        <span class="detail-value">{{ $task->updated_at?->format('d/m/Y h:i A') ?? '—' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ الموافقة</span>
                        <span class="detail-value {{ !$task->approved_at ? 'empty' : '' }}">
                            {{ $task->approved_at?->format('d/m/Y h:i A') ?? 'لم يتم بعد' }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ الرفض</span>
                        <span class="detail-value {{ !$task->rejected_at ? 'empty' : '' }}">
                            {{ $task->rejected_at?->format('d/m/Y h:i A') ?? 'لم يتم بعد' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Reject Reason (if applicable) -->
            @if($task->reject_reason)
            <div class="section">
                <div class="section-title">سبب الرفض</div>
                <div class="reject-box">
                    <strong>تم رفض المهمة للسبب التالي:</strong>
                    {{ $task->reject_reason }}
                </div>
            </div>
            @endif

            <!-- File Attachment -->
            <div class="section">
                <div class="section-title">المرفقات</div>
                @if($task->file)
                    <div class="file-attachment">
                        <div class="file-icon">📎</div>
                        <div class="file-info">يوجد ملف مرفق بالمهمة</div>
                    </div>
                @else
                    <div class="no-file">📂 لا توجد مرفقات</div>
                @endif
            </div>

        </div>

        <!-- Signatures + Footer -->
        <div class="bottom-section">
            <div class="signatures">
                <div class="signature-block">
                    <div class="signature-line">توقيع الموظف</div>
                </div>
                <div class="signature-block">
                    <div class="signature-line">توقيع المدير</div>
                </div>
            </div>
            <div class="footer-row">
                <div class="footer-text">تم الطباعة بواسطة: {{ auth()->user()?->name ?? 'غير معروف' }}</div>
                <div class="footer-text">{{ now()->format('d/m/Y h:i A') }}</div>
            </div>
        </div>
    </div>

    <!-- Print Actions (hidden on print) -->
    <div class="print-actions no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ طباعة</button>
        <button class="btn btn-close" onclick="window.close()">✕ إغلاق</button>
    </div>

    <script>
        window.addEventListener('load', function () {
            setTimeout(function () { window.print(); }, 500);
        });
    </script>
</body>
</html>
