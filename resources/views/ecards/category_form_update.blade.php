<div class="row">
    @foreach($ecard_categories as $ecard_category)
    <div class="col-sm-6">
        <h4 class="text-center">{{$ecard_category->name}}</h4><hr>
        @foreach($ecard_category->children as $category)
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>{{$category->name}}</label>
                    <div id="categories_div_{{$category->id}}">
                        <label style="display: none;">
                            {{Form::checkbox('ecard_categories[]',$category->id,$ecard->ecardcategories()->where('ecard_categories.id',$category->id)->exists(),['class'=>'categories autosave', 'id'=>'categories_input_'.$category->id])}}
                        </label>
                    </div>
                    <span class="text-danger small">{{$errors->first('ecard_categories')}}</span>
                </div>
            </div>
            @php
                $primary = $ecard->ecardcategories()->where('ecard_categories.id',$category->id)->exists() &&
                            $ecard->ecardcategories()->where('ecard_categories.id',$category->id)->first()->pivot->type == 1;

                $secondary = $ecard->ecardcategories()->where('ecard_categories.id',$category->id)->exists() &&
                            $ecard->ecardcategories()->where('ecard_categories.id',$category->id)->first()->pivot->type == 2;
            @endphp
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="radio-inline">
                        <label style="font-weight: normal;">
                            {{Form::radio('groups['.$category->id.']','',$primary,['checked', 'class'=>'autosave groups_'.$category->id])}} None
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label style="font-weight: normal;">
                            {{Form::radio('groups['.$category->id.']',1,$primary,['class'=>'autosave groups_'.$category->id])}} Primary
                        </label>
                    </div>
                    <div class="radio-inline">
                        <label style="font-weight: normal;">
                            {{Form::radio('groups['.$category->id.']',2,$secondary,['class'=>'autosave groups_'.$category->id])}} Secondary
                        </label>
                    </div><br>
                    <span class="text-danger small">{{$errors->first('groups.'.$category->id)}}</span>
                </div>
            </div>
        </div>
        @push('js')
        <script type="text/javascript">
            $(document).ready(function(){

            $(".groups_<?php echo($category->id);?>").change(function() {

            var val = $(this).val();

            var clicked = false;

            if (val == "") {

                $("#categories_input_<?php echo($category->id);?>").prop('disabled',true).prop('checked',false);

            } else if (val == "1") {

                $("#categories_input_<?php echo($category->id);?>").prop("checked", !clicked);
                clicked = !clicked;
                this.innerHTML = clicked ? 'Deselect' : 'Select';

            } else if (val == "2") {

                $("#categories_input_<?php echo($category->id);?>").prop("checked", !clicked);
                clicked = !clicked;
                this.innerHTML = clicked ? 'Deselect' : 'Select';

            }

            });

            });
            </script>
            @endpush
        @endforeach
    </div>
    @endforeach
</div>


