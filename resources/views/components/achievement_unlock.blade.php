<div role="achievement" id="achievement" style="border-radius: 25px;height: 50px;background: green;margin: auto;padding: 10px;width: 350px;position: fixed;left: 50%;transform: translateX(-50%);">
    <i class="fas fa-trophy" style="width: 50px; height: 50px; background-color: #338c33; padding: 18px; border-radius: 25px; margin: -10px;"></i>
    <div class="achievement" style="padding-left: 50px; margin-top:-37px;">
        <div class="achievement-header">
            <b>Achievement Unlocked</b>
        </div>
        <div class="achievement-body">
            {{ $achievement->data->name }}
        </div>
    </div>
</div>
