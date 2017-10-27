@section('script')
    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');

        $('#title').on('blur', function() {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug'),
                theSlug = theTitle.replace(/&/g, '-and-')
                    .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
					.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
					.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
					.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
					.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
					.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
					.replace(/đ/gi, 'd')
					.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '')
					.replace(/ /gi, "-");

            slugInput.val(theSlug);
        });

        $('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
			locale: 'vi',
            showClear: true
        });

        $('#draft-btn').click(function(e) {
            e.preventDefault();
            $('#published_at').val("");
            $('#post-form').submit();
        });
    </script>
@endsection
