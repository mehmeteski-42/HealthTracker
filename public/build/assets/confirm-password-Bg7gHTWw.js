import{m as p,j as s,L as m}from"./app-DyF-kW_i.js";import{L as l,I as c,a as u}from"./label-BYg0j7wE.js";import{B as w}from"./app-logo-icon-nFl8LgA0.js";import{A as f,L as h}from"./auth-layout-CMnLe7gD.js";import"./index-DwJ3K46G.js";function v(){const{data:o,setData:e,post:t,processing:a,errors:i,reset:n}=p({password:""}),d=r=>{r.preventDefault(),t(route("password.confirm"),{onFinish:()=>n("password")})};return s.jsxs(f,{title:"Confirm your password",description:"This is a secure area of the application. Please confirm your password before continuing.",children:[s.jsx(m,{title:"Confirm password"}),s.jsx("form",{onSubmit:d,children:s.jsxs("div",{className:"space-y-6",children:[s.jsxs("div",{className:"grid gap-2",children:[s.jsx(l,{htmlFor:"password",children:"Password"}),s.jsx(c,{id:"password",type:"password",name:"password",placeholder:"Password",autoComplete:"current-password",value:o.password,autoFocus:!0,onChange:r=>e("password",r.target.value)}),s.jsx(u,{message:i.password})]}),s.jsx("div",{className:"flex items-center",children:s.jsxs(w,{className:"w-full",disabled:a,children:[a&&s.jsx(h,{className:"h-4 w-4 animate-spin"}),"Confirm password"]})})]})})]})}export{v as default};
