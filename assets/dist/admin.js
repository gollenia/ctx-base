!function(){"use strict";window.addEventListener("DOMContentLoaded",(()=>{const e=document.getElementsByTagName("input");for(let t of e)if("color"===t.type){const e=document.createElement("input");e.value=t.value,e.classList.add("ctx-hex-input"),e.pattern="#[0-9A-Fa-f]{6}",t.insertAdjacentElement("afterend",e),e.addEventListener("change",(e=>{t.value=e.target.value})),t.addEventListener("change",(t=>{e.value=t.target.value}))}}),!1),window.addEventListener("DOMContentLoaded",(()=>{const e=document.getElementsByClassName("ctx-link-modal");for(const t of e)t.addEventListener("click",(e=>{const t=e.target.parentNode,n=document.createElement("textarea");n.id="ctx-link-textarea",n.style="display:none;",document.body.appendChild(n),jQuery(document).on("wplink-open",(()=>{document.getElementById("wp-link-wrap").classList.add("has-text-field")})),jQuery(document).on("wplink-close",(()=>{document.getElementById("wp-link-wrap").classList.add("has-text-field");const e=document.getElementById("ctx-link-textarea"),n=document.createElement("div");n.innerHTML=e.value.trim();const a=n.firstChild;t.querySelector("#input-title").value=a.innerHTML,t.querySelector("#input-url").value=a.getAttribute("href"),t.querySelector("#link-preview").innerHTML=a.getAttribute("href")})),wpLink.open("ctx-link-textarea")}))}))}();