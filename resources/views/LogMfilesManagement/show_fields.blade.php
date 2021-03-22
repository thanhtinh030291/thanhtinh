<div class="card-body table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr class="bg-info text-white">
                <th scope="col" class="noVis">STT</th>
                <th scope="col" class="noVis">Link (ID Etalk)</th>
                <th scope="col" class="noVis">Claim Type</th>
                <th scope="col" class="noVis">CL No</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($LogMfiles as $key => $item)
            <tr>
                <td>{!! $key + 1 !!}</td>
                <td><a target="_blank" rel="noopener" href="{!! url('/admin/claim/'.$item->claim_id) !!}">Link Etalk "{{$item->barcode}}"</a></td>
                <td>{!! $item->claim_type !!}</td>
                <td>{!! $item->cl_no !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>