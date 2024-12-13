@if ($templates)
    @foreach ($templates as $row)
        @php
            $text = $row->text_msg;
            $template_id = $row->template_id;
            $title = $row->title;
            $explode = explode(PHP_EOL, $text);
        @endphp
        <div class="card border-1 p-1">
            <div class='viewTemplate '>
                <div style="font-size: 13px;">
                    @foreach ($explode as $data)
                        {{ $data }} <br>
                    @endforeach
                </div>
                <div>
                    <button class="btn btn-sm mx-1 btn-outline-primary pull-right btnEdit" title="Edit Template">
                        <i class="fas fa-sm fa-pen"></i> </button>
                    <button class="btn btn-sm mx-1 btn-outline-info pull-right btnSelectTemplate"
                        data-text="{{ $text }}" data-templateid="{{ $template_id }}" data-title="{{$title}}" title="Select This Template">
                        <i class="fa fa-check" aria-hidden="true"></i> </button>
                </div>
            </div>
            <div class='updateTemplate d-none'>
                <form action="javascript:void(0)" method="post" id="updTemplateFrm">
                    <div>
                        <input type="hidden" id="id" name="id" value="{{ $row->id }}">
                        <textarea class="form-control form-control-sm" id="text_msg" name="text_msg" cols="2" rows="4"
                            style="width: 76%;">
@foreach ($explode as $data)
{{ $data }}
@endforeach
</textarea>
                    </div>
                    <div>
                        <button class="btn btn-sm mx-1 btn-outline-warning pull-right btnCancel" title="Cancel Edit">
                            X
                        </button>
                        <button type="submit" class="btn btn-sm mx-1 btn-outline-success pull-right btnSave"
                            title="Save Template">
                            <i class="fas fa-save"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endif
