import{_ as y,c as h,h as r,s as c,a as t,F as f,r as g,d as u,t as o,v as b,e as M,o as m,w as v,l as w}from"./_plugin-vue_export-helper-de6cf830.js";const S={props:["api_token","trans"],data(){return{stripe:"",elements:"",card:"",intentToken:"",name:"",addPaymentStatus:0,addPaymentStatusError:"",paymentMethods:[],paymentMethodsLoadStatus:0,paymentMethodSelected:0,showNewPaymentMethod:!1,savePaymentMethodStatus:0,deletingPaymentMethodStatus:0,json_trans:[],isLoading:!1}},mounted(){this.includeStripe("js.stripe.com/v3/",function(){this.configureStripe()}.bind(this)),this.loadIntent(),this.loadPaymentMethods(),this.json_trans=JSON.parse(this.trans)},methods:{includeStripe(e,s){let d=document,l="script",i=d.createElement(l),a=d.getElementsByTagName(l)[0];i.src="https://"+e,s&&i.addEventListener("load",function(n){s(null,n)},!1),a.parentNode.insertBefore(i,a)},configureStripe(){this.stripe=Stripe(this.api_token),this.elements=this.stripe.elements(),this.card=this.elements.create("card",{hidePostalCode:!0}),this.card.mount("#card-element")},loadIntent(){axios.get("/subscription-api/setup-intent").then(function(e){this.intentToken=e.data}.bind(this))},submitPaymentMethod(){this.addPaymentStatus=1,this.savePaymentMethodStatus=1,this.isLoading=!0,this.stripe.confirmCardSetup(this.intentToken.client_secret,{payment_method:{card:this.card,billing_details:{name:this.name}}}).then(function(e){this.savePaymentMethodStatus=0,this.isLoading=!1,e.error?(this.addPaymentStatus=3,this.addPaymentStatusError=e.error.message):(this.savePaymentMethod(e.setupIntent.payment_method),this.addPaymentStatus=2,this.card.clear(),this.name="",this.toggleShowNewPaymentMethod())}.bind(this))},savePaymentMethod(e){this.paymentMethodsLoadStatus=0,axios.post("/subscription-api/payments",{payment_method:e}).then(function(){this.loadPaymentMethods()}.bind(this))},loadPaymentMethods(){this.paymentMethodsLoadStatus=1,axios.get("/subscription-api/payment-methods").then(function(e){this.paymentMethods=e.data,this.paymentMethodsLoadStatus=2}.bind(this))},removePaymentMethod(e){this.paymentMethodsLoadStatus=0,axios.post("/subscription-api/remove-payment",{id:e}).then(function(s){this.loadPaymentMethods()}.bind(this))},toggleShowNewPaymentMethod(){this.openModal("cardModal"),this.showNewPaymentMethod=!this.showNewPaymentMethod},translate(e){return this.json_trans[e]??"unknown"},openModal(e){this.$refs[e].showModal(),this.$refs[e].addEventListener("click",function(s){let d=this.getBoundingClientRect();!(d.top<=s.clientY&&s.clientY<=d.top+d.height&&d.left<=s.clientX&&s.clientX<=d.left+d.width)&&s.target.tagName==="DIALOG"&&this.close()})},closeModal(e){this.$refs[e].close()},saveBtnClass(){let e="w-full rounded px-6 py-2.5 uppercase border border-blue-500 bg-white text-blue-500 font-extrabold hover:bg-blue-500 hover:text-white hover:shadow-sm";return this.isLoading&&(e+=" loading"),e}}},x={class:"text-center"},P=t("i",{class:"fa-solid fa-spin fa-spinner"},null,-1),k=[P],C={class:"box-body"},L={class:"row"},N={class:"col-xs-2"},B={class:"col-xs-7"},E={class:"col-xs-3 text-right"},T=["onClick"],j=t("i",{class:"fa-solid fa-trash","aria-hidden":"true"},null,-1),I=t("span",{class:"sr-only"},"Remove card",-1),D=[j,I],A={class:"help-block"},R=t("i",{class:"far fa-credit-card","aria-hidden":"true"},null,-1),V={class:"dialog rounded-2xl text-center",id:"modal-card",ref:"cardModal","aria-modal":"true","aria-labelledby":"modal-card-label"},F={id:"modal-card-label"},O=t("i",{class:"fa-solid fa-times","aria-hidden":"true"},null,-1),U=t("span",{class:"sr-only"},"Close",-1),X=[O,U],Y={class:"text-justify"},z={class:"mb-2 w-full"},G={class:"mb-2 w-full"},J=t("div",{id:"card-element"},null,-1),q={class:"help-block mb-2"},H={class:"grid grid-cols-2 gap-2"};function K(e,s,d,l,i,a){return m(),h("div",null,[r(t("div",x,k,512),[[c,i.paymentMethodsLoadStatus!=2]]),r(t("div",null,[(m(!0),h(f,null,g(i.paymentMethods,(n,_)=>(m(),h("div",{key:"method-"+_,class:"box box-solid"},[t("div",C,[t("div",L,[t("div",N,o(n.brand.charAt(0).toUpperCase())+o(n.brand.slice(1)),1),t("div",B,o(a.translate("ending"))+": "+o(n.last_four)+" Exp: "+o(n.exp_month)+" / "+o(n.exp_year),1),t("div",E,[t("span",{onClick:v(W=>a.removePaymentMethod(n.id),["stop"]),title:"Remove",class:"text-red"},D,8,T)])])])]))),128))],512),[[c,i.paymentMethodsLoadStatus==2&&i.paymentMethods.length>0]]),r(t("div",null,[t("p",A,[u(o(a.translate("add_one"))+" ",1),t("a",{href:"#",onClick:s[0]||(s[0]=(...n)=>a.toggleShowNewPaymentMethod&&a.toggleShowNewPaymentMethod(...n))},[R,u(" "+o(a.translate("actions.add_new")),1)])])],512),[[c,i.paymentMethodsLoadStatus==2&&i.paymentMethods.length==0]]),t("dialog",V,[t("header",null,[t("h4",F,o(a.translate("new_card")),1),t("button",{type:"button",class:"rounded-full",onClick:s[1]||(s[1]=n=>a.closeModal("accessModal")),title:"Close"},X)]),t("article",Y,[t("div",z,[t("label",null,o(a.translate("card_name")),1),r(t("input",{id:"card-holder-name",type:"text","onUpdate:modelValue":s[2]||(s[2]=n=>i.name=n),class:"form-control"},null,512),[[b,i.name]])]),t("div",G,[t("label",null,o(a.translate("card")),1),J]),t("p",q,o(a.translate("helper")),1),t("div",H,[t("button",{type:"button",class:"w-full rounded px-6 py-2.5 uppercase font-extrabold hover:bg-gray-200 hover:shadow-sm",onClick:s[3]||(s[3]=n=>a.closeModal("cardModal"))},"Close"),t("button",{type:"button",class:M(a.saveBtnClass()),onClick:s[4]||(s[4]=(...n)=>a.submitPaymentMethod&&a.submitPaymentMethod(...n)),ref:"formBtn"},o(a.translate("actions.save")),3)])])],512)])}const Q=y(S,[["render",K]]),p=w({});p.component("billing-management",Q);p.mount("#billing");
