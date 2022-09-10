<template> 
<div class="mt-2">
        <table class="table table-bordered text-center" >
            <tr class="gantt-head">
                <th class="border">車種</th>
                <th class="border" v-for="n in 24" :key="n-1"  colspan="4">{{n-1}}時</th>
        </tr>
        <tr>
            <th class="border gantt-head">車A</th>
            <!-- keyの数字が被らないよう*100をして工夫 -->
            <td class="border gantt-data" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(1,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])" ></td>
        </tr>
        <tr>
            <th class="border gantt-head">車B</th>
            <td class="border gantt-data" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(2,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        <tr>
            <th class="border gantt-head">車C</th>
            <td class="border gantt-data" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(3,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
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

            //csrf対策
            // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                //24時00分の時に、0時00分表示とする
                if(this.e_h==24){
                    this.e_h = 0;
                }

                // 表示の変更
                document.getElementById('start_hour').value = this.s_h;
                document.getElementById('start_mint').value = this.s_m;
                document.getElementById('end_hour').value = this.e_h;
                document.getElementById('end_mint').value = this.e_m;
            }
        }
    }
</script>