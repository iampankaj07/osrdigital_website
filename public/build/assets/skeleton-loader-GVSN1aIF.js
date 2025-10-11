var r=(i,e)=>()=>(e||i((e={exports:{}}).exports,e),e.exports);var v=r((k,o)=>{class a{constructor(){this.activeLoaders=new Set}show(e,t="default",l={}){const s=document.getElementById(e);if(!s){console.warn(`Element with ID '${e}' not found`);return}s.dataset.originalContent||(s.dataset.originalContent=s.innerHTML),s.style.display="none";const n=document.createElement("div");n.id=`${e}-skeleton`,n.className="skeleton-container",n.innerHTML=this.generateSkeleton(t,l),s.parentNode.insertBefore(n,s.nextSibling),this.activeLoaders.add(e)}hide(e){const t=document.getElementById(e),l=document.getElementById(`${e}-skeleton`);if(!t||!l){console.warn(`Skeleton loader for '${e}' not found`);return}l.remove(),t.style.display="",this.activeLoaders.delete(e)}toggle(e,t,l="default",s={}){t?this.show(e,l,s):this.hide(e)}showMultiple(e){e.forEach(({id:t,type:l="default",options:s={}})=>{this.show(t,l,s)})}hideMultiple(e){e.forEach(t=>{this.hide(t)})}generateSkeleton(e,t={}){const l={table:()=>this.generateTableSkeleton(t),card:()=>this.generateCardSkeleton(t),list:()=>this.generateListSkeleton(t),form:()=>this.generateFormSkeleton(t),stats:()=>this.generateStatsSkeleton(t),navigation:()=>this.generateNavigationSkeleton(t),content:()=>this.generateContentSkeleton(t),modal:()=>this.generateModalSkeleton(t),filepond:()=>this.generateFilePondSkeleton(t),quill:()=>this.generateQuillSkeleton(t),tabs:()=>this.generateTabsSkeleton(t),pagination:()=>this.generatePaginationSkeleton(t),default:()=>this.generateDefaultSkeleton(t)};return(l[e]||l.default)()}generateTableSkeleton(e={}){const t=e.rows||5,l=e.cols||4;let s='<table class="skeleton-table w-full">';s+="<thead><tr>";for(let n=0;n<l;n++)s+='<th><div class="skeleton-text short"></div></th>';s+="</tr></thead>",s+="<tbody>";for(let n=0;n<t;n++){s+="<tr>";for(let d=0;d<l;d++)s+='<td><div class="skeleton-text medium"></div></td>';s+="</tr>"}return s+="</tbody></table>",s}generateCardSkeleton(e={}){return`
            <div class="skeleton-card">
                <div class="skeleton-title"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-text short"></div>
                <div class="flex justify-between items-center mt-4">
                    <div class="skeleton-button"></div>
                    <div class="skeleton-badge"></div>
                </div>
            </div>
        `}generateListSkeleton(e={}){const t=e.items||5;let l='<div class="skeleton-list">';for(let s=0;s<t;s++)l+=`
                <div class="skeleton-list-item">
                    <div class="skeleton-avatar"></div>
                    <div class="skeleton-content">
                        <div class="skeleton-text long"></div>
                        <div class="skeleton-text medium"></div>
                    </div>
                </div>
            `;return l+="</div>",l}generateFormSkeleton(e={}){const t=e.fields||5;let l='<div class="space-y-6">';for(let s=0;s<t;s++)l+=`
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-input"></div>
                </div>
            `;return l+=`
            <div class="flex justify-end space-x-3">
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
            </div>
        </div>`,l}generateStatsSkeleton(e={}){const t=e.cards||4;let l='<div class="skeleton-stats">';for(let s=0;s<t;s++)l+=`
                <div class="skeleton-stat-card">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-title"></div>
                    <div class="skeleton-progress">
                        <div class="skeleton-progress-bar"></div>
                    </div>
                </div>
            `;return l+="</div>",l}generateNavigationSkeleton(e={}){const t=e.items||6;let l='<div class="skeleton-nav">';for(let s=0;s<t;s++)l+=`
                <div class="skeleton-nav-item">
                    <div class="skeleton-text short"></div>
                </div>
            `;return l+="</div>",l}generateContentSkeleton(e={}){return`
            <div class="skeleton-content">
                <div class="skeleton-title"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-image"></div>
                <div class="skeleton-text long"></div>
                <div class="skeleton-text short"></div>
            </div>
        `}generateModalSkeleton(e={}){return`
            <div class="skeleton-modal">
                <div class="skeleton-title"></div>
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-input"></div>
                </div>
                <div class="skeleton-form-group">
                    <div class="skeleton-text short"></div>
                    <div class="skeleton-textarea"></div>
                </div>
                <div class="flex justify-end space-x-3">
                    <div class="skeleton-button"></div>
                    <div class="skeleton-button"></div>
                </div>
            </div>
        `}generateFilePondSkeleton(e={}){return`
            <div class="skeleton-filepond">
                <div class="skeleton-text medium"></div>
            </div>
        `}generateQuillSkeleton(e={}){return'<div class="skeleton-quill"></div>'}generateTabsSkeleton(e={}){const t=e.tabs||3;let l='<div class="skeleton-tabs">';for(let s=0;s<t;s++)l+=`
                <div class="skeleton-tab">
                    <div class="skeleton-text short"></div>
                </div>
            `;return l+="</div>",l}generatePaginationSkeleton(e={}){return`
            <div class="skeleton-pagination">
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
                <div class="skeleton-button"></div>
            </div>
        `}generateDefaultSkeleton(e={}){return`
            <div class="space-y-4">
                <div class="skeleton-text long"></div>
                <div class="skeleton-text medium"></div>
                <div class="skeleton-text short"></div>
            </div>
        `}showOverlay(e="Loading..."){const t=document.createElement("div");t.id="skeleton-overlay",t.className="skeleton-overlay",t.innerHTML=`
            <div class="skeleton-card">
                <div class="text-center">
                    <div class="skeleton-spinner mx-auto mb-4"></div>
                    <div class="skeleton-text medium mx-auto"></div>
                </div>
            </div>
        `,document.body.appendChild(t)}hideOverlay(){const e=document.getElementById("skeleton-overlay");e&&e.remove()}async withSkeleton(e,t,l,s={}){try{return this.show(e,t,s),await l()}finally{this.hide(e)}}getActiveLoaders(){return Array.from(this.activeLoaders)}clearAll(){this.activeLoaders.forEach(e=>{this.hide(e)}),this.activeLoaders.clear()}}window.SkeletonLoader=new a;window.showSkeleton=(i,e="default",t={})=>{window.SkeletonLoader.show(i,e,t)};window.hideSkeleton=i=>{window.SkeletonLoader.hide(i)};window.toggleSkeleton=(i,e,t="default",l={})=>{window.SkeletonLoader.toggle(i,e,t,l)};window.showSkeletonOverlay=i=>{window.SkeletonLoader.showOverlay(i)};window.hideSkeletonOverlay=()=>{window.SkeletonLoader.hideOverlay()};document.addEventListener("DOMContentLoaded",function(){setTimeout(()=>{window.SkeletonLoader.clearAll()},1e3)});typeof o<"u"&&o.exports&&(o.exports=a)});export default v();
