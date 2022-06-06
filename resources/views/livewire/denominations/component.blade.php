<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-plills">
                    <li>
                        <a href="javascript:void(0)" class="tabmenu bg-dark" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-white text-center">TIPO</th>
                                <th class="table-th text-white text-center">VALOR</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $coin)
                            <tr>
                                <td><h6>{{$coin->type}}</h6></td>
                                <td><h6 class="text-center">${{number_format($coin->value,2)}}</h6></td>
                                <td class="text-center">
                                    <span>
                                        <img src="{{ asset('storage/denominations/'. $coin->imagen)}}" alt="Imagen de ejemplo" height="70" width="80" class="rounded">
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" wire:click="Edit({{$coin->id}})" class="btn btn-dark mtmobile" title="Edit">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    
                                    <a href="javascript:void(0)" onclick="Confirm('{{$coin->id}}')" class="btn btn-dark mtmobile" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>

                                   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.denominations.form')
</div>


<script>
    document.addEventListener('DOMContentLoaded', function(){
   

        window.livewire.on('item-added', msg =>{
            $('#theModal').modal('hide')
        });

        window.livewire.on('item-updated', msg =>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('item-deleted', msg =>{
          
        });

        window.livewire.on('modal-show', msg =>{
            $('#theModal').modal('show')
        });

        window.livewire.on('modal-hide', msg =>{
            $('#theModal').modal('hide')
        });

        $('#theModal').on('hidden.bs.modal', function (e) {
            $('.er').css('display','none')
        })
        

    });


   function Confirm($id){

        swal({
            title: 'CONFIRMAR',
            text: 'CONFIRMAS ELMINAR EL REGISTRO',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('deleteRow', $id)
                swal.close()
            }
        })
    }
</script>