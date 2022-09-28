<template>
    <div>
        <form method="POST" action="/reservation">
            <div>
                <input type="hidden" name="_token" :value="csrf"></input>
                <table>
                    <tr>
                        <th colspan="4">【日付】{{ calendarDate }}の予約</th>
                    </tr>
                    <tr>
                        <th>【車種】</th>
                        <td class="pe-4">
                            <select name="car_sel" id="car_sel">
                                <option value="">選択</option>
                                <template v-for='car in carsSelect'>
                                    <option :value="car.id" :key="car.id">{{car.name}}</option>
                                </template>
                            </select>
                        </td>
                    <!-- </tr>
                    <tr> -->
                        <th>【開始時刻】</th>
                        <input type="hidden" name="start_date" id="start_date" :value="calendarDate"></input>
                        <td>
                            <select name="start_hour" id="start_hour">
                            <option value=""></option>
                            <option v-for="n in 24" :value="n-1" :key="n">{{n-1}}</option>
                            </select>
                            時
                            <select name="start_mint" id="start_mint">
                                <option value=""></option>
                                <option v-for="td_sp in td_span" :value="td_sp" :key="td_sp">{{td_sp}}</option>
                            </select>
                            分
                        </td>
                        <span class="ps-2 pe-2">〜</span>
                        <th>【終了時刻】</th>
                        <input type="hidden" name="end_date" id="end_date" :value="calendarDate">
                        <td>
                            <select name="end_hour" id="end_hour">
                                <option value=""></option>
                                <option v-for="n in 25" v-bind:value="n-1" :key="n">{{n-1}}</option>
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
            </div>
            <div>
                <textarea class="memo-form mt-1" placeholder="使用用途を記入" name="memo" id="memo" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-secondary p-1 ms-1">予約する</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            calendarDate: String,
            carsSelect: Array,
        },
        mounted() {
            console.log('ReserveFormComponent mounted.');
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