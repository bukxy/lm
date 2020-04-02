$(document).ready(function () {
    let c = Object.create(objCalcul);
    c.init();
});

let objCalcul = {

    init: function () {
        let context = this;

        $('.calculator input').val("");
        $('.result .r-total span').html("0");

        $('.calculator input').on('keyup click', function (e) {
            let maxNb = 1000000;
            let minNb = 0
            if ($(e.currentTarget).val() > maxNb) $(e.currentTarget).val(maxNb);
            if ($(e.currentTarget).val() < minNb) $(e.currentTarget).val(minNb);
            context.additionSpeedUpResearch();
            context.merging();
            context.additionSpeedUpTraining();
            context.additionSpeedUpHealing();
            context.additionSpeedUpWall();
            context.additionTotal();
        });
    },

    speedUp: function () {
        let s1m = 1 * $('#spu-1m').val();
        let s3m = 3 * $('#spu-3m').val();
        let s5m = 5 * $('#spu-5m').val();
        let s10m = 10 * $('#spu-10m').val();
        let s15m = 15 * $('#spu-15m').val();
        let s30m = 30 * $('#spu-30m').val();
        let s60m = 60 * $('#spu-60m').val();
        let s3h = (60 * 3) * $('#spu-3h').val();
        let s8h = (60 * 8) * $('#spu-8h').val();
        let s15h = (60 * 15) * $('#spu-15h').val();
        let s24h = (60 * 24) * $('#spu-24h').val();
        let s3d = ((60*24)*3)  * $('#spu-3d').val();
        let s7d = ((60*24)*7) * $('#spu-7d').val();
        let s30d = ((60*24)*30) * $('#spu-30d').val();

        let m = s1m + s3m + s5m + s10m + s15m + s30m + s60m;
        let h = s3h + s8h + s15h + s24h;
        let d = s3d + s7d + s30d;
        let totalSU = m + h + d;

        let days = Math.floor(totalSU / 1440);
        let hours = Math.floor((totalSU-(days*1440)) / 60);
        let minutes = Math.round(totalSU % 60);

        $('.result .r-speedUp .r-total .days span').html(days);
        $('.result .r-speedUp .r-total .hours span').html(hours);
        $('.result .r-speedUp .r-total .minutes span').html(minutes);
        
        return totalSU;
    },

    research: function () {
        let s10m = 10 * $('#rs-10m').val();
        let s15m = 15 * $('#rs-15m').val();
        let s30m = 30 * $('#rs-30m').val();
        let s60m = 60 * $('#rs-60m').val();
        let s3h = (60 * 3) * $('#rs-3h').val();
        let s8h = (60 * 8) * $('#rs-8h').val();
        let s15h = (60 * 15) * $('#rs-15h').val();
        let s24h = (60 * 24) * $('#rs-24h').val();
        let s3d = ((60 * 24) * 3) * $('#rs-3d').val();

        let m = s10m + s15m + s30m + s60m;
        let h = s3h + s8h + s15h + s24h;
        let d = s3d;
        let totalR = m + h + d;

        let days = Math.floor(totalR / 1440);
        let hours = Math.floor((totalR - (days * 1440)) / 60);
        let minutes = Math.round(totalR % 60);

        $('.result .r-research .r-total .days span').html(days);
        $('.result .r-research .r-total .hours span').html(hours);
        $('.result .r-research .r-total .minutes span').html(minutes);

        return totalR;
    },

    additionSpeedUpResearch: function () {
        let total = this.speedUp() + this.research();
        let days = Math.floor(total / 1440);
        let hours = Math.floor((total - (days * 1440)) / 60);
        let minutes = Math.round(total % 60);
        $('.result .r-suR .days span').html(days);
        $('.result .r-suR .hours span').html(hours);
        $('.result .r-suR .minutes span').html(minutes);
    },

    merging: function () {
        let s1m = 1 * $('#mg-1m').val();
        let s15m = 15 * $('#mg-15m').val();
        let s60m = 60 * $('#mg-60m').val();
        let s3h = (60 * 3) * $('#mg-3h').val();
        let s8h = (60 * 8) * $('#mg-8h').val();
        let s15h = (60 * 15) * $('#mg-15h').val();
        let s24h = (60 * 24) * $('#mg-24h').val();
        let s3d = ((60 * 24) * 3) * $('#mg-3d').val();
        let s7d = ((60 * 24) * 7) * $('#mg-7d').val();

        let m = s1m + s15m + s60m;
        let h = s3h + s8h + s15h + s24h;
        let d = s3d + s7d;
        let totalM = m + h + d;

        let days = Math.floor(totalM / 1440);
        let hours = Math.floor((totalM - (days * 1440)) / 60);
        let minutes = Math.round(totalM % 60);

        $('.result .r-merging .r-total .days span').html(days);
        $('.result .r-merging .r-total .hours span').html(hours);
        $('.result .r-merging .r-total .minutes span').html(minutes);

        return totalM;
    },

    training: function () {
        let s30m = 30 * $('#tr-30m').val();
        let s60m = 60 * $('#tr-60m').val();
        let s3h = (60 * 3) * $('#tr-3h').val();
        let s8h = (60 * 8) * $('#tr-8h').val();
        let s24h = (60 * 24) * $('#tr-24h').val();

        let m = s30m + s60m;
        let h = s3h + s8h + s24h;
        let totalTR = m + h;

        let days = Math.floor(totalTR / 1440);
        let hours = Math.floor((totalTR - (days * 1440)) / 60);
        let minutes = Math.round(totalTR % 60);

        $('.result .r-training .r-total .days span').html(days);
        $('.result .r-training .r-total .hours span').html(hours);
        $('.result .r-training .r-total .minutes span').html(minutes);

        return totalTR;
    },

    additionSpeedUpTraining: function () {
        let total = this.speedUp() + this.training();
        let days = Math.floor(total / 1440);
        let hours = Math.floor((total - (days * 1440)) / 60);
        let minutes = Math.round(total % 60);
        $('.result .r-suT .days span').html(days);
        $('.result .r-suT .hours span').html(hours);
        $('.result .r-suT .minutes span').html(minutes);    },

    healing: function () {
        let s15m = 15 * $('#he-15m').val();
        let s60m = 60 * $('#he-60m').val();
        let s3h = (60 * 3) * $('#he-3h').val();

        let m = s15m + s60m;
        let h = s3h;
        let totalH = m + h;

        let days = Math.floor(totalH / 1440);
        let hours = Math.floor((totalH - (days * 1440)) / 60);
        let minutes = Math.round(totalH % 60);

        $('.result .r-healing .r-total .days span').html(days);
        $('.result .r-healing .r-total .hours span').html(hours);
        $('.result .r-healing .r-total .minutes span').html(minutes);

        return totalH;
    },

    additionSpeedUpHealing: function () {
        let total = this.speedUp() + this.healing();
        let days = Math.floor(total / 1440);
        let hours = Math.floor((total - (days * 1440)) / 60);
        let minutes = Math.round(total % 60);
        $('.result .r-suH .days span').html(days);
        $('.result .r-suH .hours span').html(hours);
        $('.result .r-suH .minutes span').html(minutes);    },

    wall: function () {
        let s15m = 15 * $('#wa-15m').val();
        let s60m = 60 * $('#wa-60m').val();

        let s3h = (60 * 3) * $('#wa-3h').val();
        let s8h = (60 * 8) * $('#wa-8h').val();
        let s24h = (60 * 24) * $('#wa-24h').val();

        let m = s15m + s60m;
        let h = s3h + s8h + s24h;
        let totalWA = m + h;

        let days = Math.floor(totalWA / 1440);
        let hours = Math.floor((totalWA - (days * 1440)) / 60);
        let minutes = Math.round(totalWA % 60);

        $('.result .r-wall .r-total .days span').html(days);
        $('.result .r-wall .r-total .hours span').html(hours);
        $('.result .r-wall .r-total .minutes span').html(minutes);
        return totalWA;
    },

    additionSpeedUpWall: function () {
        let total = this.speedUp() + this.wall();
        let days = Math.floor(total / 1440);
        let hours = Math.floor((total - (days * 1440)) / 60);
        let minutes = Math.round(total % 60);
        $('.result .r-suW .days span').html(days);
        $('.result .r-suW .hours span').html(hours);
        $('.result .r-suW .minutes span').html(minutes);    },

    additionTotal: function() {
        let total = this.speedUp() + this.research() + this.merging() + this.training() + this.healing() + this.wall();
        let days = Math.floor(total / 1440);
        let hours = Math.floor((total - (days * 1440)) / 60);
        let minutes = Math.round(total % 60);
        $('.result .r-cumul .days span').html(days);
        $('.result .r-cumul .hours span').html(hours);
        $('.result .r-cumul .minutes span').html(minutes);    }
}