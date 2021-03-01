<ul style="margin-left: 10px;">
    @foreach($childs as $child)
        <li>
	    <label class="post_users" data-id="{{$child->id}}" for="{{$child->id}}" style="padding: 5px; cursor: pointer;"> {{$child->title_uz}} </label>
            <input name="child" value="{{$child->id}}" type="checkbox" style="display: none" />
            <ul style="margin-left: 10px;">
                <li>
                    <div class="form-group" id="usersdiv{{$child->id}}" style="margin-bottom: 0">

                    </div>
                </li>
            </ul>
            @if(count($child->childs))
                @include('components.ajax',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>