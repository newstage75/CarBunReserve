<template>
            <form class="mt-3" method="POST" action="/reservation">
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
                    <td><input type="date" name="start_date" id="start_date"></input></td>
                    <td>
                        <select name="start_hour" id="start_hour">
                        <option value=""></option>
                        <option v-for="n in 24" v-bind:value="n-1" :key="n">{{n-1}}</option>
                        </select>
                        時
                        <select name="start_mint" id="start_mint">
                            <option value=""></option>
                            <option v-for="td_sp in td_span" :value="td_sp" :key="td_sp">{{td_sp}}</option>
                        </select>
                        分
                    </td>
                    <span class="ps-2 pe-2">〜</span>
                    <th>終了時刻</th>
                    <td><input type="date" name="end_date" id="end_date"></td>
                    <td>
                        <select name="end_hour" id="end_hour">
                            <option value=""></option>
                            <option v-for="n in 24" v-bind:value="n-1" :key="n">{{n-1}}</option>
                        </select>
                        時
                        <select name="end_mint" id="end_mint">
                            <option value=""></option>
                            <option v-for="td_sp in td_span" :value="td_sp" :key="td_sp">{{td_sp}}</option>
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
            console.log('ReserveFormComponent mounted.');
             //今日の日時を表示
            window.onload = function () {
                //今日の日時を表示
                let date = new Date()
                let year = date.getFullYear()
                let month = date.getMonth() + 1
                let day = date.getDate()

                let toTwoDigits = function (num, digit) {
                num += ''
                if (num.length < digit) {
                    num = '0' + num
                }
                return num
                }

                let yyyy = toTwoDigits(year, 4)
                let mm = toTwoDigits(month, 2)
                let dd = toTwoDigits(day, 2)
                let ymd = yyyy + "-" + mm + "-" + dd;

                //カレンダーの日付用
                document.getElementById("calendar_date").value = ymd;
                //入力部分の日付用
                document.getElementById("start_date").value = ymd;
                document.getElementById("end_date").value = ymd;
            };
        },
        data:function() {
            return {
            td_span:[0,15,30,45],

            //csrf対策
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        }
    }
</script>