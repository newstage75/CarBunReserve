<template>
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
                    <td><input type="date" name="start_date" value="2022-09-06"></input></td>
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
                    <td><input type="date" name="end_date" value="2022-09-06"></td>
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
</template>

<script>
    export default {
        mounted() {
            console.log('ReservationTimeTable mounted.')
        },
        data:function() {
            return {
            td_span:[0,15,30,45],

            //csrf対策
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
    }
</script>