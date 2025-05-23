<style>
    @media print {
        /* Hide unnecessary elements when printing */
        .fi-topbar,
        .fi-sidebar,
        .fi-header-heading button,
        .fi-tabs nav,
        .fi-footer,
        .fi-ac-btn-action:not([data-action-name="print"]) {
            display: none !important;
        }

        /* Ensure the content takes up the full page */
        .fi-main {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        /* Make text darker for better printing */
        body {
            color: #000 !important;
            background: #fff !important;
        }

        /* Ensure all content is visible */
        .fi-section {
            page-break-inside: avoid;
            margin-bottom: 20px !important;
        }

        /* Add a title at the top of the printed page */
        .fi-header::before {
            content: "Audit Trail Record";
            display: block;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Add timestamp at the bottom */
        .fi-main::after {
            content: "Printed on: " attr(data-print-date);
            display: block;
            text-align: center;
            font-size: 12px;
            margin-top: 30px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('open-print-dialog', function() {
            // Add current date to the main element for printing
            const now = new Date();
            const formattedDate = now.toLocaleString();
            document.querySelector('.fi-main').setAttribute('data-print-date', formattedDate);

            // Trigger print dialog
            window.print();
        });
    });
</script>
