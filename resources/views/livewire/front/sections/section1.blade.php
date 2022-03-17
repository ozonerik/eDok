<section class="clean-block clean-hero" style="background-image:url('{{asset('img/tech/image2.jpg')}}');color:rgba(9, 162, 255, 0.85);">
    <div class="text row">
        <div class="col-12 h2 text-light">Jumlah File Terupload Tahun    {{ \Carbon\Carbon::now()->format('Y')}}</div>
        <div class="col-12 mb-4" wire:ignore>
            <canvas id="blngraph"></canvas>
        </div>
        <div class="col-12">
            <button wire:click="changetahun" class="btn btn-success" type="button">Reload</button>
        </div>  
    </div>
</section>