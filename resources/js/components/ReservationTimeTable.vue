<template> 
<div class="m-3">
        <h1>Vue予約画面</h1>
        <table class="table table-bordered text-center" >
            <tr>
                <th class="border">車種</th>
                <th class="border" v-for="n in 24" :key="n-1"  colspan="4">{{n-1}}時</th>
        </tr>
        <tr>
            <th class="border">車A</th>
            <!-- keyの数字が被らないよう*100をして工夫 -->
            <td class="border" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(1,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])" ></td>
        </tr>
        <tr>
            <th class="border">車B</th>
            <td class="border" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(2,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        <tr>
            <th class="border">車C</th>
            <td class="border" v-for="m in td_time" :key="m[0]*100+m[1]" @mousedown="onMousedown(3,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        </table>

        <form method="POST" action="/reservation">
            <input type="hidden" name="_token" :value="csrf"></input>
            <table>
                <tr>
                    <th>車種</th>
                    <td>
                        <select name="car_sel" id="car_sel">
                            <option value="">選択</option>
                            <option value="1">車A</option>
                            <option value="2">車B</option>
                            <option value="3">車C</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>開始時刻</th>
                    <td><input type="date" name="start_date"></input></td>
                    <td>
                        <select name="start_hour" id="start_hour">
                        <option value=""></option>
                        <option v-for="n in 24" v-bind:value="n-1" :key="n">{{n-1}}</option>
                        </select>
                        時
                        <select name="start_mint" id="start_mint">
                            <option value=""></option>
                            <option v-for="td_sp in td_span" v-bind:value="td_sp" :key="td_sp">{{td_sp}}</option>
                        </select>
                        分
                    </td>
                    <span class="ps-2 pe-2">　〜　</span>
                    <th>終了時刻</th>
                    <td><input type="date" name="end_date"></td>
                    <td>
                        <select name="end_hour" id="end_hour">
                            <option value=""></option>
                            <option v-for="n in 24" v-bind:value="n-1" :key="n">{{n-1}}</option>
                        </select>
                        時
                        <select name="end_mint" id="end_mint">
                            <option value=""></option>
                            <option v-for="td_sp in td_span" v-bind:value="td_sp" :key="td_sp">{{td_sp}}</option>
                        </select>
                        分
                    </td>
                </tr>
            </table>
            <textarea class="mt-2" placeholder="使用用途を記入" name="memo" id="memo" cols="70" rows="5"></textarea>
            <button type="submit" class="ms-3">予約する</button>
        </form>
    </div>
</template>

<script>
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
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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