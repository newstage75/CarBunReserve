<template> 
<div class="mt-1 gantt-parent">
            <!-- デバッグ用 予約済みの配列を渡す -->
             <!-- <div class="bg-white border border-3 mb-3">
             <h4>デバッグ用Laravelから渡されたデータ群</h4>
             <div v-for='reserve in carReserved'>
                <p :key="reserve.id">【車種ID】{{reserve.car_id}}【開始】{{reserve.start_at}}【終了】{{reserve.end_at}}</p>
             </div>
            <p>{{reserveBlock}}</p>
             </div> -->
        <!-- v-forを使った表現 -->
        <table class="table table-bordered text-center gantt-chart">
            <tr class="gantt-head">
                <th class="border border-primary">車種</th>
                <th class="border border-primary time-head" v-for="n in 24" :key="n-1"  colspan="4">{{n-1}}時</th>
            </tr>
            <tr v-for='car in carsSelect' :key="car.id">
                <th class="border border-primary gantt-head">{{car.name}}</th>
                <!-- keyの数字が被らないよう*100をして工夫 -->
                <td class="border border-primary gantt-data" v-for="m in td_time" :key="m[0]*100+m[1]" :class="{ gannt_reserved: isReserved(car.id,m[0],m[1]) }" @mousedown="onMousedown(car.id,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])" ></td>
            </tr>
        </table>

    </div>
</template>

<script>
    //ガントチャート用のtd_timeを作成する用の計算
    let td_span = [0,15,30,45];
    let td_time = [];

    for(let i=0;i<24;i++){
        td_span.forEach(function(element){
            td_time.push([i,element])
        })
    };

    export default {
        props: {
            carsSelect: Array,
            carReserved: Array,
            reserveBlock: Array,
        },
        mounted() {
            console.log('ReservationTimeTable mounted.')
        },
        data:function() {
            return {
            car:"",
            mousedown_time:"",
            mouseup_time:"",
            s_h:"",
            s_m:"",
            e_h:"",
            e_m:"",

            //ガントチャート用時刻
            td_time:td_time,
            td_span:td_span,

            //テスト用予約済みテーブルの配列[車種、時、分]でブロックごとに予約の有無を確認
            // reserved:[[1,1,15],[1,1,30],[1,1,45],
            //           [2,15,15],[2,15,30],[2,15,45],
            //           [3,20,15],[3,20,30],[3,20,45]],
            
            reserved: this.reserveBlock,

            }
        },
        methods: {
            onMousedown(car,h,m){
                this.mousedown_time = h+"時"+m+"分";
                this.car = car;
                // セレクトボックスのvalue変更
                document.getElementById('car_sel').value = car;
                //まずスタートタイムに代入（マウスアップの時刻と比較し開始時刻・終了時刻を決定）
                this.s_h = h;
                this.s_m = m;
                //テスト用（のちに削除）
                console.log(td_time);
                console.log(td_span);
                },
            onMouseup(h,m){
                this.mouseup_time = h+"時"+m+"分";
                //マウスダウンとの比較と代入
                if(h<this.s_h || (h==this.s_h && m<this.s_m)){
                    this.e_h = this.s_h;
                    this.e_m = this.s_m;
                    this.s_h = h;
                    this.s_m = m;
                }else{
                    this.e_h = h;
                    this.e_m = m;
                }
                //endの時間を+15分する
                if(this.e_m===45){
                    this.e_h += 1;
                    this.e_m = 0;
                }else{
                    this.e_m += 15;
                }
                //24時00分の時に、0時00分表示とする←24:45まで許容することで対応した
                // if(this.e_h==24){
                //     this.e_h = 0;
                // }

                // 表示の変更
                document.getElementById('start_hour').value = this.s_h;
                document.getElementById('start_mint').value = this.s_m;
                document.getElementById('end_hour').value = this.e_h;
                document.getElementById('end_mint').value = this.e_m;
            },
            //予約されているか否かの確認
            isReserved(car_id,m0,m1){ //車種、予約時間(m0時:m1分)に予約があるか確認
                for (const block of this.reserved) {
                    if(block[0]===car_id && block[1]===m0 && block[2]===m1){
                        return true;
                    }
                }
            }
        },
    }
</script>