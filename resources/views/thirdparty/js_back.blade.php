<script src="{{ asset('assets/plugins/alertifyjs/alertify.min.js') }}"></script>
<!-- Bootstrap 4 -->
@if(session('locale') == 'ar')
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@else
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
@endif
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Include the Quill library -->
<script src="{{ asset('assets/js/quill.js') }}"></script>
<script src="{{ asset('assets/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<!-- Select 2 js -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $(window).scrollTop(0);

        $('.dropify').dropify();

        $(".flatpickr").flatpickr({
            enableTime: false
        });

        $(".flatpickr-pick-time").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        $(".flatpickr-date-time").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        $(".today-flatpickr").flatpickr({
            enableTime: false,
            defaultDate: "today"
        });

        $(".select2").select2();

        $('#laravel_datatable').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "order": [],
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });

        $('#myModal').on('show.bs.modal', function(e) {
            console.log($(e.relatedTarget).data('href'));
            $(this).find('.btn-ok').attr('action', $(e.relatedTarget).data('href'));
        });
        document.querySelector('.btn-ok').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = e.target;
    const url = form.getAttribute('action');

    const formData = new FormData(form);

    try {
if (url.startsWith("http://")) {
    console.log(url, '1');
        url = url.replace("http://", "https://");
         console.log(url, '2');
    }
        const response = await fetch(url, {
            method: "POST",
            body: formData,
            credentials: "same-origin"
        });
 console.log(url, '3');
        if (response.ok) {
            location.reload(); // refresh page after delete
        } else {
            alert("Delete failed");
        }

    } catch (err) {
        console.error("Delete error:", err);
        alert("Network error");
    }
});
    });

    $(document).on('click', '#doPrint', function(){
        var printContent = $('#print-area').html();
        $('body').html(printContent);
        window.print();
        location.reload();
    });
</script>
