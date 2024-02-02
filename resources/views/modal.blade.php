<div class="offcanvas offcanvas-end eOffcanvas" id="rightOffcanvas" data-bs-scroll="true" tabindex="-1" id="offcanvasScrollingRightBS" aria-labelledby="rightOffcanvasTitle">
    <div class="offcanvas-header justify-content-end">
        <h6 id="rightOffcanvasTitle" class="me-auto"></h6>

        <a href="#" class="offcanvas-btn" data-bs-dismiss="offcanvas" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                <path
                    d="M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z" />
            </svg>
        </a>
    </div>
    <div class="offcanvas-body border-top mt-3 pt-3" id="rightOffcanvasBody"></div>
</div>

<!-- Modal -->
<div class="modal eModal fade" id="confirmSweetAlerts" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered sweet-alerts text-sweet-alerts">
        <div class="modal-content">
            <div class="modal-body">
                <div class="icon icon-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                        <path d="M22.5 29V10H25.5V29ZM22.5 38V35H25.5V38Z" />
                    </svg>
                </div>
                <p>{{get_phrase('Are you sure?')}}</p>
                <p class="focus-text">
                    {{get_phrase('Click Yes if you want to do that')}}
                </p>
                <div class="confirmBtn">
                    <button type="button" class="eBtn eBtn-red" data-bs-dismiss="modal">
                        {{get_phrase('Cancel')}}
                    </button>
                    <a id="confirmBtn" class="eBtn eBtn-green text-white lh-40px">
                        {{get_phrase('Yes')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    "use strict";

    function showRightModal(url, title) {
        $('#rightOffcanvasTitle').text(title);
        $('#rightOffcanvasBody').html('<div class="text-center pt-5 mt-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');


        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                console.log(response);
                $('#rightOffcanvasBody').html(response);
            }
        });


        const myOffcanvas = document.getElementById('rightOffcanvas');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        bsOffcanvas.show();
    }

    function confirmModal(url) {
        const confirmSweetAlerts = new bootstrap.Modal('#confirmSweetAlerts', {
            keyboard: false
        })
        $('#confirmSweetAlerts #confirmBtn').attr('href', url);
        confirmSweetAlerts.show();
    }
</script>
