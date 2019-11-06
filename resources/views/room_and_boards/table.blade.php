<div class="table-responsive">
    <table class="table" id="roomAndBoards-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Code Claim</th>
        <th>Time Start</th>
        <th>Time End</th>
        <th>Created User</th>
        <th>Updated User</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roomAndBoards as $roomAndBoard)
            <tr>
                <td>{!! $roomAndBoard->name !!}</td>
            <td>{!! $roomAndBoard->code_claim !!}</td>
            <td>{!! $roomAndBoard->time_start !!}</td>
            <td>{!! $roomAndBoard->time_end !!}</td>
            <td>{!! $roomAndBoard->created_user !!}</td>
            <td>{!! $roomAndBoard->updated_user !!}</td>
                <td>
                    {!! Form::open(['route' => ['roomAndBoards.destroy', $roomAndBoard->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('roomAndBoards.show', [$roomAndBoard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('roomAndBoards.edit', [$roomAndBoard->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
