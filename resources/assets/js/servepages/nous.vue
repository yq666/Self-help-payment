<template>
<div class="layout-box">
    <sheader headerTitle="用电常识"></sheader>
    <div class="layout-application">
        <div class="application-box">
            <BackTop :height="200" :bottom="50" :right="10" :duration="1000"></BackTop>
            <Scroll :on-reach-bottom="handleReachBottom" :height="getViewPortHeight">            
            <ul class="news-lists">
                <li v-for="values in topicsData" :key="values.id">
                    <div class="news-box">
                        <router-link :to="{name: 'article', params: {id: values.id}}">
                            <div class="news-left">
                                <p class="news-title" :v-model="topicsData">{{values.title}}</p>
                                <p class="info">
                                    <span>{{values.created_at}}</span>
                                    <span class="margin-left" v-if="values.user!==undefined">{{values.user.nickname}}</span>
                                    <span class="margin-left">
                                        <i class="iconfont icon-sannongguancha">{{values.view_count}}</i>
                                    </span>
                                </p>
                            </div>
                            <div class="news-right">
                                <img :src="values.title_image_path" alt="">
                            </div>
                        </router-link>
                    </div>
                </li>
            </ul>
            </Scroll>
        </div>  
    </div>
</div>
</template>
<script>
import sheader from '../components/box.vue'
export default {
    components:{
        sheader
    },
  data() {
    return {
      current_page: null,
      total_pages: null,
      topicsData: [{ id: "" }, { title: "" }, { body: "" }],

    };
  },
  computed: {
    // 获取浏览器窗口的可视区域的高度
    getViewPortHeight: function() {
      return document.documentElement.clientHeight - 45;
    }
  },
  mounted() {
    // 文章
    this.$http.get("use_electrical_sense").then(res => {
      this.topicsData = res.body.topics;
    });
  },
  methods: {
    handleReachBottom() {
      if (this.current_page >= this.total_pages) {
        return false;
      } else {
        return new Promise(resolve => {
          this.$http
            .get("topics", {
              params: {
                page: ++this.current_page
              }
            })
            .then(res => {
              for (let i in res.body.data) {
                this.topicsData.push(res.body.data[i]);
              }
            });
        });
      }
    }
  }
};
</script>
<style scoped>
.layout-box {
  position: absolute;
  top: 0px;
  padding: 0px 0px;
  width: 100%;
  height: 100%;
  background: #fff;
}
.header-title{
    display: flex;
    flex-direction: column;
}
.layout-box .header-title p {
  color: #fff;
  line-height: 45px;
  z-index: 999;
  font-size: 18px;
}
.layout-application {
  position: absolute;
  top: 25px;
  padding: 0 10px;
  text-align: left;
  width: 100%;
  background: #fff;
}
.application-box {
  padding-top: 10px;
}
/* 用电常识 */
.news-container {
  padding-top: 150px;
}
.news {
  background: #fff;
  padding: 20px 0;
}
.news-box {
  width: 100%;
  height: 100%;
  position: relative;
}
.news-lists li {
  flex-direction: row;
  display: flex;
  padding: 10px 0px;
  overflow: hidden;
  background-color: #fff;
  border-bottom: 1px solid #eee;
  height: 90px;
}
.news-box a {
  display: block;
  height: 100%;
}
.news-left {
  width: 60%;
  float: left;
  padding-right: 5px;
}
.news-right {
  width: 40%;
  height: 100%;
  float: left;
}
.news-box .news-title {
  font-size: 14px;
  color: #444;
  text-align: left;
  padding-bottom: 5px;
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 2;
  overflow: hidden;
}
.news-box .info {
  color: #999;
  font-size: 12px;
  text-align: left;
  margin-bottom: 0px;
  position: absolute;
  bottom: 0px;
}
.news-box .info .margin-left {
  margin-left: 10px !important;
}
.news-right img {
  width: 100%;
  height: 100%;
  border-radius: 5px;
}
.get-more {
  height: 20px;
  position: relative;
  padding: 20px 0;
}
</style>
