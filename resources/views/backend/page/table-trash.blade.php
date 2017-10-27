<table class="table table-bordered">
    <thead>
        <tr>
            <td width="80">Action</td>
            <td>Title</td>
            <td width="120">Author</td>
            <td width="170">Date</td>
        </tr>
    </thead>
    <tbody>
        <?php $request = request(); ?>

        @foreach($pages as $page)

            <tr>
                <td>
                    {!! Form::open(['style' => 'display:inline-block;', 'method' => 'PUT', 'route' => ['backend.page.restore', $page->id]]) !!}
                        @if (check_user_permissions($request, "Page@restore", $page->id))
                            <button title="Restore" class="btn btn-xs btn-default">
                                <i class="fa fa-refresh"></i>
                            </button>
                        @else
                            <button title="Restore" onclick="return false;" class="btn btn-xs btn-default disabled">
                                <i class="fa fa-refresh"></i>
                            </button>
                        @endif
                    {!! Form::close() !!}

                    {!! Form::open(['style' => 'display:inline-block;', 'method' => 'DELETE', 'route' => ['backend.page.force-destroy', $page->id]]) !!}
                        @if (check_user_permissions($request, "Page@forceDestroy", $page->id))
                            <button title="Delete Permanent" onclick="return confirm('You are about to delete a page permanently. Are you sure?')" type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        @else
                            <button title="Delete Permanent" onclick="return false;" type="submit" class="btn btn-xs btn-danger disabled">
                                <i class="fa fa-times"></i>
                            </button>
                        @endif
                    {!! Form::close() !!}
                </td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->author->name }}</td>
                <td>{{ $page->category->title }}</td>
                <td>
                    <abbr title="{{ $page->dateFormatted(true) }}">{{ $page->dateFormatted() }}</abbr>
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
