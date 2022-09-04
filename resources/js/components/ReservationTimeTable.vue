<template> 
<div>
        <table class="table table-bordered text-center">
            <tr>
                <th>車種</th>
                <th  v-for="n in 24" :key="n-1"  colspan="4">{{n-1}}時</th>
        </tr>
        <tr>
            <th>車A</th>
            <td v-for="m in td_time" :key="m[0]" @mousedown="onMousedown(1,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        <tr>
            <th>車B</th>
            <td v-for="m in td_time" :key="m[0]" @mousedown="onMousedown(2,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        <tr>
            <th>車C</th>
            <td v-for="m in td_time" :key="m[0]" @mousedown="onMousedown(3,m[0],m[1])" @mouseup="onMouseup(m[0],m[1])"></td>
        </tr>
        </table>

        <table>
            <tr>
                <th>車種</th>
                <td>
                    <select name="room_sel" id="room_sel">
                        <option value="">選択</option>
                        <option value="1">車A</option>
                        <option value="2">車B</option>
                        <option value="3">車C</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>開始時刻</th>
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
            </tr>
            <tr>
                <th>終了時刻</th>
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
            console.log('Component mounted.')
        },
        data() {
            return {
            room:"",
            mousedown_time:"",
            mouseup_time:"",
            s_h:"",
            s_m:"",
            e_h:"",
            e_m:"",

            //ガントチャート用時刻(もしかしたら不要)
            td_time:td_time,
            td_span:td_span,
            }
        },
        methods: {
            onMousedown(room,h,m){
                this.mousedown_time = h+"時"+m+"分";
                this.room = room;
                // セレクトボックスのvalue変更
                document.getElementById('room_select').value = room;
                document.getElementById('room_sel').value = room;
                document.getElementById('hour1').value = h;
                document.getElementById('mint1').value = m;
                //まずスタートタイムに代入（マウスアップの時刻と比較し開始時刻・終了時刻を決定）
                this.s_h = h;
                this.s_m = m;
                //テスト用（のちに削除）
                // document.getElementById('start_hour').value = this.s_h;
                // document.getElementById('start_mint').value = this.s_m;
                console.log(td_time);
                console.log(td_span);
                },
            onMouseup(h,m){
                this.mouseup_time = h+"時"+m+"分";
                // セレクトボックスのvalue変更
                document.getElementById('hour2').value = h;
                document.getElementById('mint2').value = m;
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
                // 表示の変更
                document.getElementById('start_hour').value = this.s_h;
                document.getElementById('start_mint').value = this.s_m;
                document.getElementById('end_hour').value = this.e_h;
                document.getElementById('end_mint').value = this.e_m;
            }
        }
    }
</script>