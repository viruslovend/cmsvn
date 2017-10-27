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
                    {!! Form::open(['method' => 'DELETE', 'route' => ['backend.page.destroy', $page->id]]) !!}
                        @if (check_user_permissions($request, "Page@edit", $page->id))
                            <a href="{{ route('backend.page.edit', $page->id) }}" class="btn btn-xs btn-default">
                                <i class="fa fa-edit"></i>
                            </a>
                        @else
                            <a href="#" class="btn btn-xs btn-default disabled">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif

                        @if (check_user_permissions($request, "Page@destroy", $page->id))
                            <button type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        @else
                            <button type="button" onclick="return false;" class="btn btn-xs btn-danger disabled">
                                <i class="fa fa-trash"></i>
                            </button>
                        @endif
                    {!! Form::close() !!}
                </td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->author->name }}</td>
                <td>
                    <abbr title="{{ $page->dateFormatted(true) }}">{{ $page->dateFormatted() }}</abbr> |
                    {!! $page->publicationLabel() !!}
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
