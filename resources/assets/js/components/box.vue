<template>
  <div class="layout">
      <div class="layout-header">
            <a href="javascript:;" @click="back" class="return"><Icon type="android-arrow-back" color="#fff" size="28"></Icon></a>
            <p>{{headerTitle || '掌电'}}</p>
        </div>
        <router-view/>
  </div>
</template>
<script>
export default {
    props: {
        headerTitle: String
    },
  methods: {
    back() {
      this.$router.back(-1);
    }
  }
};
</script>
<style scoped>
.layout {
  background: #fff;
  position: relative;
  height: 100%;
  width: 100%;
}
.layout-box {
  position: absolute;
  top: 0px;
  padding: 0px 0px;
  width: 100%;
  padding-bottom: 65px;
}
.layout-contain {
  position: relative;
  padding-bottom: 50px;
  height: 100%;
}
.layout-header {
  height: 45px;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  color: #fff;
  background: #1bbc9b;
  line-height: 45px;
  font-size: 18px;
  z-index: 999;
  padding: 0 10px;
}
.layout-header .return {
  float: left;
  line-height: 45px;
  position: absolute;
  left: 20px;
  top: 8px;
}
.ivu-btn-success {
  color: #fff;
  background-color: #1bbc9b;
  border-color: #1bbc9b;
}
</style>
