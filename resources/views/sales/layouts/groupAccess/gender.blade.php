<div class="choose">
    <div class="genderOption">
        <input type="radio" class="btn-check" name="gender[{{$model->id}}]" value="male" id="option1{{$model->id}}">
        <label class=" mb-0 btn btn-outline" for="option1{{$model->id}}">
            <span> <i class="fas fa-male"></i> </span>
        </label>
    </div>
    <div class="genderOption">
        <input type="radio" class="btn-check" name="gender[{{$model->id}}]" value="female" id="option2{{$model->id}}">
        <label class=" mb-0 btn btn-outline" for="option2{{$model->id}}">
            <span> <i class="fas fa-female"></i> </span>
            <!-- <span> female </span> -->
        </label>
    </div>
</div>
