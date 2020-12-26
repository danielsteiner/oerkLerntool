<div class="media" style="margin: 10px 0px 10px 0px;">
    <i class="fas fa-trophy" style="width: 30px; height: 30px; padding: 15px 0px 15px 0px;"></i>
    <div class="media-body">
        <div class="row">
            <div class="col-md-10">
                <h5 class="mt-0">{{ $achievement->data->name }}</h5>
                <p>{{ $achievement->data->description }}</p>
            </div>
            <div class="col-md-2">
                <p style="text-align:right;vertical-align:bottom; font-size:20px;">{{ $achievement->percent }}%</p>
            </div>
        </div>
        <div class="progressbar" style="margin-bottom: 10px;margin-top:-10px;background-color: gray;">
            <div class="progress" style="width:{{ $achievement->percent }}%; height: 2px; background-color:green;"></div>
        </div>
    </div>
</div>
