/* 根据不同的浏览器加载相应的修正样式表文件。*/
function loadFixedCSS()
{
    cssFile = '';
    if($.browser.msie && Math.floor(parseInt($.browser.version)) == 6)
    {
        cssFile = themeRoot + 'ie.6.css';
    }
    else if($.browser.mozilla) 
    {
        cssFile = themeRoot + 'firefox.css';
    }
    if(cssFile != '')
    {
        document.write("<link rel='stylesheet' href='" + cssFile + "' type='text/css' media='screen' />");
    }
}

/* JS版本的createLink。*/
function createLink(moduleName, methodName, vars, viewType)
{
    link = webRoot;
    if(!viewType) viewType = defaultView;
    if(vars)
    {
        vars = vars.split('&');
        for(i = 0; i < vars.length; i ++) vars[i] = vars[i].split('=');
    }
    if(requestType == 'PATH_INFO')
    {
        link += moduleName + requestFix + methodName;
        if(vars)
        {
            if(pathType == "full")
            {
                for(i = 0; i < vars.length; i ++) link += requestFix + vars[i][0] + requestFix + vars[i][1];
            }
            else
            {
                for(i = 0; i < vars.length; i ++) link += requestFix + vars[i][1];
            }
        }
        link += '.' + viewType;
    }
    else
    {
        link += '?' + moduleVar + '=' + moduleName + '&' + methodVar + '=' + methodName + '&' + viewVar + '=' + viewType;
        if(vars) for(i = 0; i < vars.length; i ++) link += '&' + vars[i][0] + '=' + vars[i][1];
    }
    return link;
}

/* 自动设置所有属性为nobr的title。*/
function setNowrapObjTitle()
{
    $('.nobr').each(function (i) 
    {
        if($.browser.mozilla) 
        {
            this.title = this.textContent;
        }
        else
        {
            this.title = this.innerText;
        }
    })
}

/* 选择产品。*/
function switchProduct(productID, type)
{
    if(type == 'product')
    {
        link = createLink('product', 'browse', 'productID=' + productID);
    }
    else if(type == 'bug')
    {
        link = createLink('bug', 'browse', 'productID=' + productID + '&type=byModule&param=0');
    }
    else if(type == 'case')
    {
        link = createLink('testcase', 'browse', 'productID=' + productID + '&type=byModule&param=0');
    }
    location.href=link;
}

/* 选择项目。*/
function switchProject(projectID)
{
    link = createLink('project', 'browse', 'projectID=' + projectID);
    location.href=link;
}

/* 选择用户。*/
function switchAccount(account)
{
    link = createLink('user', 'view', 'account=' + account);
    location.href=link;
}

/* 设置ping的地址，防止session超时。*/
function setPing()
{
    $('#hiddenwin').attr('src', createLink('misc', 'ping'));
}

/* 设置必填字段。*/
function setRequiredFields()
{
    if(!requiredFields) return false;
    requiredFields = requiredFields.split(',');
    for(i = 0; i < requiredFields.length; i++)
    {
        $('#' + requiredFields[i]).after('<span class="star"> * </span>');
    }
}

/* 设置帮助链接。*/
function setHelpLink()
{
    $('form input[id], form select[id], form textarea[id]').each(function()
        {
            if($(this).attr('type') == 'hidden' || $(this).attr('type') == 'file') return;
            currentFieldName = $(this).attr('name') ? $(this).attr('name') : $(this).attr('id');
            if(currentFieldName == 'submit' || currentFieldName == 'reset') return;
            if(currentFieldName.indexOf('[') > 0) currentFieldName = currentFieldName.substr(0, currentFieldName.indexOf('['));
            currentFieldName = currentFieldName.toLowerCase();
            $(this).after(' <a class="helplink" href=' + zentaoHelpRoot + '?lang=' + clientLang + '&module=' + currentModule + '&method=' + currentMethod + '&field=' + currentFieldName + '>?</a> ');
        }
    );
}

/* 需要不需要ping，已保证session不过期。 */
needPing = true;

/* 自动执行的代码。*/
$(document).ready(function() 
{
    setNowrapObjTitle();
    setRequiredFields();
    //setHelpLink();
    if(needPing) setTimeout('setPing()', 1000 * 60 * 5);  // 5分钟之后开始ping。
});
