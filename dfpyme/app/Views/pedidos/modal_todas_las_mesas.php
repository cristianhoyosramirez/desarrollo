<!--
<div class="modal fade" id="lista_todas_las_mesas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl ">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Mesas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="my-1"></div>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <div class="input-icon">
                            <input type="text" value="" class="form-control form-control-rounded" placeholder="Buscar mesa" onkeyup="buscar_mesas(this.value)">
                            <span class="input-icon-addon">

                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="col-10">
                    </div>
                </div>
            </div>
            <div class="my-1"></div>
            <div id="listado_de_mesas">

            </div>
            <hr>
        </div>
    </div>
</div> -->





<!-- Modal -->
<div class="modal fade" id="lista_todas_las_mesas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="my-1"></div>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <div class="input-icon">
                            <input type="text" value="" class="form-control form-control-rounded" placeholder="Buscar mesa" onkeyup="buscar_mesas(this.value)">
                            <span class="input-icon-addon">

                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="col-10">
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="listado_de_mesas"></div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>