<template>
<div class="layout-box">
    <sheader headerTitle="邮箱地址"></sheader>
    <div class="layout-application">
        <div class="application-box" style="padding-top:30px;">
            <Form class="login" ref="formInline"  :rules="ruleInline" post="" label-position="right" :label-width="70">
                <FormItem label="邮箱地址" prop="email">
                    <AutoComplete
                        v-model="email"
                        size="large"
                        @on-search="handleSearch_email"
                        placeholder="请输入您注册时的邮箱">
                        <Option aligin="left" v-for="item in emailarry" :value="item" :key="item">{{ item }}</Option>
                    </AutoComplete>
                </FormItem>
            </Form>
            <Button type="success" long @click="handleSubmit('formInline')">发送验证码</Button>
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
      email: "",
      emailarry: "",
      ruleInline: {
        email: [
          { required: true, message: "请输入邮箱", trigger: "blur" }
        ]
      }
    };
  },
  methods: {
    handleSubmit(name) {
      this.$refs[name].validate(valid => {
        if (valid) {
          this.$http
            .post("authorizations", {
              student_id: this.formInline.user,
              password: this.formInline.password,
              captcha_key: this.captchaKey,
              captcha_code: this.formInline.verification
            })
            .then(
              res => {
                this.$router.push("./Reset");
              },
              err => {
                this.$Message.error(err.body.message || "提交失败");
              }
            );
        } else {
          this.$Message.error("输入的数据格式有误，请检查!");
        }
      });
    },
    handleSearch_email(value) {
      this.emailarry =
        !value || value.indexOf("@") >= 0
          ? []
          : [value + "@qq.com", value + "@sina.com", value + "@163.com"];
    }
  }
};
</script>
<style>
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
  top: 45px;
  padding: 0 10px;
  text-align: left;
  width: 100%;
  padding-bottom: 65px;
  background: #fff;
}
.application-box {
  padding-top: 10px;
}
</style>

