<?php
$title = 'Assessment Application';
$active = 'apply';
echo view('layouts/dashboard-header', [
    'title'        => $title,
    'userName'     => $userName ?? 'User',
    'userInitials' => $userInitials ?? 'U',
    'sidebar'      => view('layouts/sidebar-startup', ['active' => $active]),
]);
?>

    <div class="page-header">
      <h1 class="page-title">Apply for CREDENCE Assessment</h1>
      <p class="page-desc">Submit your company for official CREDENCE Tech Due-Diligence & Verification Certification</p>
    </div>

    <div class="card" id="apply-card">
      <div class="card-header">
        <h3 class="card-title">Assessment Application Tier</h3>
      </div>
      <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--radius-md); padding:1.25rem; margin-bottom:1.5rem;">
        <h4 style="font-family:'Outfit',sans-serif; font-size:1.3rem; color:var(--primary); margin-bottom:4px;">
          Full CREDENCE Tech Due-Diligence & Trust Score Assessment
        </h4>
        <p style="font-size:0.92rem; color:#334155;">
          Includes 9-parameter expert evaluator assessment, dynamic score report, unique Verification ID issuance, QR code digital badge, and listing in the public CREDENCE Verified Directory.
        </p>
        <div style="margin-top:12px; font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#0f172a;">
          Assessment Fee: ₹4,999 <small style="font-size:0.85rem; color:#64748b; font-weight:normal;">+ GST</small>
        </div>
      </div>

      <button id="btn-trigger-payment" class="btn btn-primary">Proceed to Payment & Submit Application</button>
    </div>

<script>
document.getElementById('btn-trigger-payment').addEventListener('click', function() {
  alert('Payment gateway abhi connect nahi hua hai — backend teammate se baat karni hai Razorpay/payment API ke liye.');
});
</script>

<?php echo view('layouts/dashboard-footer'); ?>