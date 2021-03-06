<div>
    <x-LoadingState />
    <section class="clean-block about-us">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Download File</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card text-center">
                        <div class="card-body">
                            @if(!empty($myfile->count()))
                            <h4 class="card-title">{{ $c }}</h4>
                            <div class="table-responsive">
                                <table class="table table-borderless table-light">
                                    <thead class="table-info">
                                        <tr>
                                            <th colspan="2" class="text-center">File Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="fw-bold">File Name</td>
                                            <td>@foreach($myfile as $row) {{$row->myfile->name}} @endforeach</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Category Name</td>
                                            <td>@foreach($myfile as $row) {{$row->myfile->filecategory->name}} @endforeach</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Owner Name</td>
                                            <td>@foreach($myfile as $row) {{$row->myfile->user->name}} @endforeach</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Size</td>
                                            <td>@foreach($myfile as $row) {{convert_bytes($row->myfile->file_size)}} @endforeach</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Recipient</td>
                                            <td>@foreach($myfile as $row) {{$row->receiveuser->name}} @endforeach</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <form method="post" enctype="multipart/form-data" autocomplete="off" wire:submit.prevent="cobadownload">
                                <div class="bg-light rounded">
                                    <div class="form-group d-flex justify-content-center p-2">
                                        <div class="input-group">
                                            <input type="password" class="form-control" wire:model.defer="recipientpass" placeholder="Please enter recipient password" aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit">Download</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @else
                            <h4 class="card-title text-danger">File Not Found. </h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
