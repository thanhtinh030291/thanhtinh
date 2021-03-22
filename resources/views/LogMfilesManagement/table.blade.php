<div class="table-responsive">
    <table class="table" id="reportAdmins-table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Tổng Bộ Hồ Sơ</th>
                {{-- <th>Đã Hoàn Thành</th>
                <th>Chưa Hoan Thành</th> --}}
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($LogMfiles as $LogMfile)
            <tr>
            <td>{!! $LogMfile->date !!}</td>
            {{-- <td>{!! $reportAdmin->total !!}</td> --}}<td></td>
            {{-- <td></td>
            <td></td> --}}
            <td>
                <a href="{!! route('LogMfiles.show', $LogMfile->date) !!}" class='btn btn-success btn-xs'><i class="fa fa-eye"></i></a>
                {{-- {!! Form::open(['route' => ['reportAdmins.destroy', $reportAdmin->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('reportAdmins.show', [$reportAdmin->id]) !!}" class='btn btn-success btn-xs'><i class="fa fa-eye"></i></a>
                    <a href="{!! route('reportAdmins.edit', [$reportAdmin->id]) !!}" class='btn btn-primary btn-xs'><i class="fa fa-pencil-square-o"></i></a>
                    {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!} --}}
            </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
