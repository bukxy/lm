$(document).ready(function () {

    let c = Object.create(objCalcul);
    c.init();

});

let objCalcul = {

    init: function () {
        let context = this;

        $('.calcul').on('click', function (e) {
            e.preventDefault();
            console.log('click');
            context.speedUp();
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

        let s3h = 3 * $('#spu-3h').val();
        let s8h = 8 * $('#spu-8h').val();
        let s15h = 15 * $('#spu-15h').val();
        let s24h = 24 * $('#spu-24h').val();

        console.log(s24h);

        let s3d = 3 * $('#spu-3d').val();
        let s7d = 7 * $('#spu-7d').val();
        let s30d = 30 * $('#spu-30d').val();

        let actualDateSU = new Date(); // Date actuel
        let calculDateSU = new Date(actualDateSU); // Date de calcule baser sur la date actuel

        console.log('---- Date ----')
        console.log(actualDateSU);
        console.log(calculDateSU);
        console.log('-------------')

        // calculDateSU.setHours(actualDateSU.getHours() + (3*24)); // Ajouts des jours à la date
        calculDateSU.setDate(actualDateSU.getDate() + (s3d + s7d + s30d)); // Ajouts des jours à la date

        calculDateSU.setHours(actualDateSU.getHours() + (s3h + s8h + s15h + s24h));

        calculDateSU.setMinutes(actualDateSU.getMinutes() + (s1m + s3m + s5m + s10m + s15m + s30m + s60m));

        this.dateSpeedUp(calculDateSU, actualDateSU);
    },

    dateSpeedUp: function (calculDateSU, actualDateSU) {
        let diff = {};
        let tmp = calculDateSU - actualDateSU;

        console.log(tmp / (1000 * 3600 * 24));

        tmp = Math.floor(tmp / 1000);             // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60;                    // Extraction du nombre de secondes

        tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
        diff.min = tmp % 60;                    // Extraction du nombre de minutes

        tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
        diff.hour = tmp % 24;                   // Extraction du nombre d'heures

        tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
        diff.day = tmp;

        console.log('jours = ' + diff.day);
        console.log('heures = ' + diff.hour);
        console.log('minutes = ' + diff.min);
        console.log('--------------');
        console.log(tmp);
        console.log('--------------');
        console.log('--------------');


        let test = calculDateSU - actualDateSU;

        let d1 = test / (1000 * 3600 * 24);
        let h1 = d1 / (1000 * 3600);
        let m1 = h1 / 3600;

        console.log(d1);
        console.log(h1);
        console.log(m1);
    },

    research: function () {
        let s10m = 10 * $('#rs-10m').val();
        let s15m = 15 * $('#rs-15m').val();
        let s30m = 30 * $('#rs-30m').val();
        let s60m = 60 * $('#rs-60m').val();

        let s3h = 3 * $('#rs-3h').val();
        let s8h = 8 * $('#rs-8h').val();
        let s15h = 15 * $('#rs-15h').val();
        let s24h = 24 * $('#rs-24h').val();

        let s3d = 3 * $('#rs-3d').val();

        let actualDateR = new Date(); // Date actuel
        let calculDateR = new Date(actualDateR); // Date de calcule baser sur la date actuel

        calculDateR.setDate(actualDateR.getDate() + (s3d + s7d + s30d)); // Ajouts des jours à la date

        calculDateR.setHours(actualDateR.getHours() + (s3h + s8h + s15h + s24h));

        calculDateR.setMinutes(actualDateR.getMinutes() + (s10m + s15m + s30m + s60m));
    },

    dateResearch: function (calculDateR, actualDateR) {
        let diff = {};
        let tmp = calculDateSU - actualDateSU;

        tmp = Math.floor(tmp / 1000);             // Nombre de secondes entre les 2 dates
        diff.sec = tmp % 60;                    // Extraction du nombre de secondes

        tmp = Math.floor((tmp - diff.sec) / 60);    // Nombre de minutes (partie entière)
        diff.min = tmp % 60;                    // Extraction du nombre de minutes

        tmp = Math.floor((tmp - diff.min) / 60);    // Nombre d'heures (entières)
        diff.hour = tmp % 24;                   // Extraction du nombre d'heures

        tmp = Math.floor((tmp - diff.hour) / 24);   // Nombre de jours restants
        diff.day = tmp;
    },
}