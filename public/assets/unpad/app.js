var app=angular.module('pintuApp',['ngRoute','ngSanitize','ngFileUpload']).config(['$provide','$httpProvider','$routeProvider','$controllerProvider',function($provide,$httpProvider,$routeProvider,$controllerProvider){$httpProvider.defaults.headers.common['X-Requested-With']='XMLHttpRequest';$provide.factory('$routeProvider',function(){return $routeProvider});app.controller=$controllerProvider.register}]).run(['$rootScope','$routeProvider','$route','$controller','$http','$location','$filter','$timeout','$interval','Upload',function($rootScope,$routeProvider,$route,$controller,$http,$location,$filter,$timeout,$interval,$upload){$rootScope._config={route_url:'dependency/main/routes',controller_url:'dependency/main/controllers',menu_url:'dependency/main/menus',account_url:'account-info',template_url:'assets/pintu/',routes:[],title:'',_token:''};$rootScope._guid=function(){function s4(){return Math.floor((1+Math.random())*0x10000).toString(16).substring(1)}
return s4()+s4()+'-'+s4()+'-'+s4()+'-'+s4()+'-'+s4()+s4()+s4()};$rootScope._service={http:$http,location:$location,filter:$filter,timeout:$timeout,interval:$interval,upload:$upload};$rootScope._merge=function(){var result=angular.isArray(arguments[0])?[]:{};for(var i in arguments){if(i==0&&angular.isFunction(arguments[i])){result=arguments[i];continue}
if(!angular.isObject(arguments[i]))continue;for(var name in arguments[i]){if(angular.isObject(result[name])&&angular.isObject(arguments[i][name])){result[name]=$rootScope._merge(result[name],arguments[i][name])}
else{result[name]=arguments[i][name]}}}
return result};$rootScope._equals=function(actual,expected){return actual==expected};$rootScope._find={index:function(array,find){if(!angular.isArray(array)||!angular.isObject(find))return-1;var index=-1;var total=0;var match=0;for(var i in array){if(!angular.isObject(array[i]))continue
total=0;match=0;for(var name in find){total++;if(array[i][name]==find[name]){match++}}
if(match==total){return i}}
return index},data:function(array,find){return $rootScope._service.filter('filter')(array,find,$rootScope._equals)}};$rootScope._filter={text:function(value,regex){var filtered='';var replace=angular.isDefined(arguments[2])?arguments[2]:'_';for(var i in value){var chr=value.charAt(i).replace(regex,replace);if(replace!=''||chr!=''){filtered=filtered+chr}}
return filtered},alphadash:function(value){return $rootScope._filter.text(value.toLowerCase(),/[^a-z0-9_]{1}/)}};$rootScope._share=$rootScope._merge([],{get:function(name){var defaultValue=angular.isDefined(arguments[1])?arguments[1]:null;var index=$rootScope._find.index($rootScope._share,{name:name});if(index<0){return defaultValue}
if(angular.isFunction($rootScope._share[index]))return defaultValue;return $rootScope._share[index].value},set:function(name,value){var index=$rootScope._find.index($rootScope._share,{name:name});if(angular.isFunction($rootScope._share[index]))return;if(index<0){$rootScope._share.push({guid:$rootScope._guid(),name:name,value:value});return}
$rootScope._share[index].value=value}});$rootScope._title={clear:function(){angular.element(document).prop('title',$rootScope._config.title)},set:function(title){angular.element(document).prop('title',$rootScope._config.title+' - '+title)}};$rootScope._message=$rootScope._merge([],{clear:function(){if(!angular.isDefined(arguments[0])){$rootScope._message.splice(0,$rootScope._message.length);angular.element('.field.error').removeClass('error');angular.element('.field.success').removeClass('success');angular.element('.field.warning').removeClass('warning');angular.element('.field.info').removeClass('info')}
else{var index=$rootScope._find.index($rootScope._message,{type:arguments[0]});while(index>=0){$rootScope._message.splice(index,1);index=$rootScope._find.index($rootScope._message,{type:arguments[0]})}
angular.element('.field.'+arguments[0]).removeClass(arguments[0])}},add:function(type,message){$rootScope._message.push({type:type,message:message});if(!angular.isDefined(arguments[2]))return;var key=arguments[2];var part=key.split('.');if(part.length>1){key='';for(var i in part){key+=i==0?part[i]:'['+part[i]+']'}}
angular.element('input[name="'+key+'"], textarea[name="'+key+'"], select[name="'+key+'"]').parents('.field').first().removeClass('error').addClass('error')},isExist:function(){var result=$rootScope._find.data($rootScope._message,angular.isDefined(arguments[0])?{type:arguments[0]}:{});return result.length?!0:!1}});$rootScope._loadPage=function(path){if($rootScope._service.location.path()!=path){$rootScope._loader('show')}
$rootScope._service.location.path(path)};$rootScope._data={get:function(url,callback){$rootScope._service.http.get(url).success(callback).error($rootScope._handleHttpError)},post:function(url,params,callback){params._token=$rootScope._config._token;$rootScope._service.http.post(url,params).success(callback).error($rootScope._handleHttpError)},delete:function(url,callback){var config={params:{_token:$rootScope._config._token}};$rootScope._service.http.delete(url,config).success(callback).error($rootScope._handleHttpError)},upload:function(url,params,file,callback){params._token=$rootScope._config._token;$rootScope._service.upload.upload({url:url,fields:params,file:file}).success(callback).error($rootScope._handleHttpError)}};$rootScope._loader=$rootScope._merge(function(action){$rootScope._message.clear();$rootScope._loader.show=action=='show'},{show:!1});$rootScope._showError=function(error,error_message){swal({title:error,text:error_message,type:'error',confirmButtonColor:'#DD6B55',confirmButtonText:'OK',closeOnConfirm:!1})};$rootScope._handleHttpError=function(data,status,headers,config){$rootScope._loader('hide');if(!angular.isDefined(data))return;if(status==403){swal({title:angular.isDefined(data.error)?data.error:'Akses Ditolak !',text:angular.isDefined(data.error_message)?data.error_message:'Sesi anda sudah habis atau Anda tidak memiliki hak akses yang memadai untuk mengakses halaman ini.',type:'error',confirmButtonColor:'#DD6B55',confirmButtonText:'OK',closeOnConfirm:!1},function(){document.location.reload()});return}
else if(status==422){if(angular.isObject(data)){$rootScope._message.clear('error');for(var name in data){for(var i in data[name]){$rootScope._message.add('error',data[name][i],name)}}}
return}
$rootScope._showError(angular.isDefined(data.error)?data.error:'Terjadi Masalah !',angular.isDefined(data.error_message)?data.error_message:'Silahkan mencoba kembali beberapa saat lagi.');};$rootScope._dump=function(variable){var modal=angular.element('#dump-modal');if(!modal.size()){angular.element('body').append(['<div class="ui long modal" id="dump-modal">','	<i class="close icon"></i>','	<div class="content"></div>','</div>'].join(''));var modal=angular.element('#dump-modal')}
modal.find('.content').html(variable);modal.modal('show')};var init=function(){$rootScope._loader('show');$rootScope._config.title=angular.element(document).prop('title');$rootScope._data.get($rootScope._config.route_url,function(data){$rootScope._config.routes=data.routes;angular.element.getScript($rootScope._config.controller_url,function(){for(var path in $rootScope._config.routes){$routeProvider.when(path,{templateUrl:$rootScope._config.template_url+$rootScope._config.routes[path].replace(/\//g,'-')+'/template.html',controller:angular.element.camelCase($rootScope._config.routes[path].replace(/\//g,'-'))+'Controller'})}
$routeProvider.otherwise('/');$route.reload();})})};init()}]).directive('resize',['$window',function($window){return function(scope,element,attr){var window=angular.element($window);scope.onWindowResize=function(){var sidebar=angular.element('.page-sidebar');var isVisible=sidebar.hasClass('visible');if(window.outerWidth()>=992){scope._viewport='desktop';angular.element('.page-wrapper').dimmer('hide');if(!isVisible){sidebar.sidebar('show')}}
else{scope._viewport=window.outerWidth()>=768?'tablet':'mobile';if(isVisible){sidebar.sidebar('hide')}}};window.bind('resize',function(){scope.onWindowResize();scope.$apply()});scope.onWindowResize()}}]).directive('maxlength',function(){return{restrict:'A',link:function(scope,element,attrs){var options={alwaysShow:!1,threshold:20,defaultClass:'green',warningClass:'yellow',limitReachedClass:'red',getRemain:function(object){if(!angular.isDefined(object.val()))return 0;var remain=object.attr('maxlength')-object.val().length;if(remain<0){object.val(object.val().substr(0,object.attr('maxlength')))}
return remain},calculate:function(object){var label=object.parents('.maxlength-wrapper').find('.maxlength-text');var remain=object.data('getRemain')(object);object.parents('.maxlength-wrapper').find('.maxlength-text').html(remain);label.removeClass(object.data('defaultClass')).removeClass(object.data('warningClass')).removeClass(object.data('limitReachedClass')).removeClass('hidden').addClass('hidden');if(object.data('alwaysShow')){label.removeClass('hidden').addClass(object.data('defaultClass'))}
if(remain>0&&remain<=object.data('threshold')){label.removeClass('hidden').addClass(object.data('warningClass'))}
if(remain<=0){label.removeClass('hidden').addClass(object.data('limitReachedClass'))}},hideLabel:function(object){object.parents('.maxlength-wrapper').find('.maxlength-text').addClass('hidden')}};for(var name in options){if(angular.isFunction(options[name]))continue;var attributeName=angular.element.camelCase(name);options[name]=angular.isDefined(attrs[attributeName])?attrs[attributeName]:options[name]}
var parent=element.parent('.ui.labeled.input');if(!parent.size()){parent=element}
parent.wrap('<div class="maxlength-wrapper" style="width:100%;position:relative;"></div>');element.parents('.maxlength-wrapper').append('<div class="maxlength-text ui floating label hidden"></div>');element.data(options).on('input',function(){angular.element(this).data('calculate')(angular.element(this))}).focus(function(){angular.element(this).data('calculate')(angular.element(this))}).blur(function(){angular.element(this).data('hideLabel')(angular.element(this))})}}}).directive('datepicker',function(){return{restrict:'A',require:'ngModel',link:function(scope,element,attrs,ngModel){var options={format:'YYYY-MM-DD',dayNames:['Minggu','Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu'],monthNames:['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']};for(var name in options){if(angular.isDefined(attrs[name])){options[name]=attrs[name]}}
element.data(options);element.addClass('datepicker').attr('readonly','readonly').on('click',function(){angular.element('.datepicker-input').removeClass('datepicker-input');angular.element(this).addClass('datepicker-input');angular.element(this).data('date',datePicker.getData(angular.element(this)));datePicker.render();datePicker.renderValue(angular.element(this));angular.element('.datepicker-modal').modal('show')});var datePicker={getData:function(object){var value=object.val();var format=object.data('format');var date=new Date();if(format.indexOf('DD')>=0){var data=parseInt(value.substr(format.indexOf('DD'),2));if(!isNaN(data)){date.setDate(data)}}
if(format.indexOf('MM')>=0){var data=parseInt(value.substr(format.indexOf('MM'),2));if(!isNaN(data)){date.setMonth(data-1)}}
if(format.indexOf('YYYY')>=0){var data=parseInt(value.substr(format.indexOf('YYYY'),4));if(!isNaN(data)){date.setFullYear(data)}}
return date},setDate:function(object){var date=object.data('date');var format=object.data('format');if(format.indexOf('DD')>=0){format=format.replace('DD',date.getDate()<10?'0'+date.getDate():date.getDate())}
if(format.indexOf('MM')>=0){format=format.replace('MM',date.getMonth()<9?'0'+(date.getMonth()+1):(date.getMonth()+1))}
if(format.indexOf('YYYY')>=0){format=format.replace('YYYY',date.getFullYear())}
return format},render:function(){var modal=angular.element('.datepicker-modal');if(modal.size())return;angular.element('body').append(['<div class="datepicker-modal ui small modal">','	<div class="datepicker-date-string header">[date]</div>','	<div class="content">','		<div class="ui grid">','			<div class="five wide column">','				<div class="datepicker-action ui top attached blue icon button" data-action="dayInc"><i class="plus icon"></i></div>','				<div class="datepicker-day ui center aligned attached segment">00</div>','				<div class="datepicker-action ui bottom attached blue icon button" data-action="dayDec"><i class="minus icon"></i></div>','			</div>','			<div class="five wide column">','				<div class="datepicker-action ui top attached blue icon button" data-action="monthInc"><i class="plus icon"></i></div>','				<div class="datepicker-month ui center aligned attached segment">00</div>','				<div class="datepicker-action ui bottom attached blue icon button" data-action="monthDec"><i class="minus icon"></i></div>','			</div>','			<div class="six wide column">','				<div class="datepicker-action ui top attached blue icon button" data-action="yearInc"><i class="plus icon"></i></div>','				<div class="datepicker-year ui center aligned attached segment">0000</div>','				<div class="datepicker-action ui bottom attached blue icon button" data-action="yearDec"><i class="minus icon"></i></div>','			</div>','		</div>','	</div>','	<div class="actions">','		<div class="two fluid ui buttons">','		<div class="datepicker-set ui button">Set</div>','		<div class="datepicker-cancel ui button">Cancel</div>','		</div>','	</div>','</div>'].join(''));angular.element('.datepicker-modal').modal({allowMultiple:!0,selector:{close:'.close'},onVisible:function(){angular.element(this).modal('refresh')}});angular.element('.datepicker-modal .datepicker-action').mousedown(function(){angular.element('.datepicker-modal .datepicker-action.datepicker-run-action').removeClass('datepicker-run-action');angular.element(this).addClass('datepicker-run-action');datePicker.runAction()}).mouseup(function(){angular.element(this).removeClass('datepicker-run-action')}).mouseout(function(){angular.element(this).removeClass('datepicker-run-action')});angular.element('.datepicker-modal .datepicker-set').click(function(){var object=angular.element('.datepicker-input');if(!object.size())return;object.val(datePicker.setDate(object));scope.$apply(function(){ngModel.$setViewValue(datePicker.setDate(object))});angular.element('.datepicker-modal').modal('hide')});angular.element('.datepicker-modal .datepicker-cancel').click(function(){angular.element('.datepicker-modal').modal('hide')})},renderValue:function(object){var date=object.data('date');var day=date.getDate();var month=date.getMonth()+1;var year=date.getFullYear();angular.element('.datepicker-modal .datepicker-day').html(day<10?'0'+day:day);angular.element('.datepicker-modal .datepicker-month').html(month<10?'0'+month:month);angular.element('.datepicker-modal .datepicker-year').html(year);var string='<i class="calendar icon"></i>';string+=object.data('dayNames')[date.getDay()]+', ';string+=day<10?'0'+day:day;string+=' '+object.data('monthNames')[date.getMonth()]+' ';string+=year;angular.element('.datepicker-modal .datepicker-date-string').html(string)},runAction:function(){var key=angular.element('.datepicker-modal .datepicker-action.datepicker-run-action');if(!key.size())return;var object=angular.element('.datepicker-input');if(!object.size())return;window.setTimeout(function(){datePicker.action[key.attr('data-action')](object.data('date'));
	datePicker.renderValue(object);datePicker.runAction()},200)},
action:{dayInc:function(date){return date.setDate(date.getDate()+1)},
dayDec:function(date){return date.setDate(date.getDate()-1)},
monthInc:function(date){return date.setMonth(date.getMonth()+1)},
monthDec:function(date){return date.setMonth(date.getMonth()-1)},
yearInc:function(date){return date.setFullYear(date.getFullYear()+1)},
yearDec:function(date){return date.setFullYear(date.getFullYear()-1)}}}}}}).

controller('mainController',[
	'$scope','$window',function($scope,$window){
		$scope._init=function(){
			$scope._viewport='desktop';
			$scope._render();
			$scope._account.init();
			$scope._menu.init()
		};
		$scope._account={
			username:'',
			name:'',
			image_url:'assets/images/square-image.png',
			notification:{general:0,service:0,admin:0},
			point_amount:0,
			status:0,
			expires:'',
			expired:0,
			hint_zimbra_mail:0,
			hint_bad_username:0,
			hint_bad_password:0,
			force_valid_username:0,_token:'',
			loader:!1,
			set:function(account){
				for(var name in account){
					if(angular.isFunction($scope._account[name]))continue;
					$scope._account[name]=account[name]
				}
			},
			init:function(){
				$scope._account.loader=!0;
				$scope._account.load();
				$scope._service.interval(
					$scope._account.load,30000
				)
			},
			load:function(){
				$scope._data.get(
					$scope._config.account_url,function(data){
						if(angular.isDefined(data.account)){
							$scope._account.set(data.account)
						}
						$scope._config._token=$scope._account._token;$scope._account.loader=!1
					}
				)
			}
		};
		$scope._breadcrumb=$scope._merge([],{
			clear:function(){
				$scope._breadcrumb.splice(0,$scope._breadcrumb.length)
			},
			add:function(icon,label){
				var url=angular.isString(arguments[2])?arguments[2]:'';
				$scope._breadcrumb.push({icon:icon,label:label,url:url})
			}
		});
		$scope._menu=$scope._merge([],{
			loader:!1,
			init:function(){
				$scope._menu.loader=!0;
				$scope._data.get(
					$scope._config.menu_url,
					function(data){
						for(var i in data.menus){
							if(angular.isFunction($scope._menu[i]))continue;
							$scope._menu[i]=data.menus[i]
						}
						for(var i in $scope._menu){
							if(angular.isFunction($scope._menu[i]))continue;
							$scope._menu[i].index=i;
							$scope._menu[i].guid=$scope._guid();
							for(var j in $scope._menu[i].childs){
								$scope._menu[i].childs[j].guid=$scope._guid();
								$scope._menu[i].childs[j].parentGuid=$scope._menu[i].guid
							}
						}
						$scope._menu.loader=!1
					}
				)
			},
			select:function(){
				var path=angular.isDefined(arguments[0])?arguments[0]:$scope._service.location.path();
				var menu=$scope._menu.find(path);if(menu==null)return;
				var className='content-'+$scope._config.routes[menu.href].replace(/\//g,'-');
				var currentClass=angular.element('body').attr('data-current-class');
				if(angular.isDefined(currentClass)){
					angular.element('body').removeClass(currentClass)
				}
				angular.element('body').addClass(className).attr('data-current-class',className);
				$scope._service.timeout(function(){
					angular.element('.sidebar-menu .ui.accordion .item[data-guid], .sidebar-menu .ui.accordion .title, .sidebar-menu .ui.accordion .content').removeClass('active');
					angular.element('.sidebar-menu .ui.accordion .content > .menu').removeClass('visible').addClass('hidden').css('display','none');
					var object=angular.element('.sidebar-menu .ui.accordion .item[data-guid="'+menu.guid+'"]');
					object.addClass('active').parents('.item').first().find('.title, .content').addClass('active');
					object.parents('.item').first().find('.content > .menu').removeClass('hidden').addClass('visible').removeAttr('style');
					if($scope._viewport!='desktop'){
						angular.element('.page-sidebar').sidebar('hide')
					}
				},200)
			},
			find:function(path){
				path=(path.substr(0,1)!='/'?'/':'')+path;
				var result=[];
				for(var i in $scope._menu){
					if(angular.isFunction($scope._menu[i])||!angular.isObject($scope._menu[i]))continue;
					result=$scope._find.data($scope._menu[i].childs,{href:path});if(result.length){break}
				}
				if(!result.length){
					if(path=='/'){
						return null
					}
					var part=path.split('/');
					part=part.splice(part,part.length-1,1);
					path=part.join('/');
					path=path==''?'/':path;
					return $scope._menu.find(path)
				}
				return result[0]
			}
		});
		$scope._datagrid={
			clear:function(){
				var datagrid={
					url:'',visible:!0,columns:[],items:[],filter:{},sort:{by:'',dir:'asc'},page:1,view:20,from:0,to:0,total:0,pagination:{},_sortCallback:null
				};
				for(var name in datagrid){
					$scope._datagrid[name]=datagrid[name]
				}
			},
			set:function(datagrid){
				for(var name in datagrid){
					if(angular.isFunction($scope._datagrid[name]))continue;
					$scope._datagrid[name]=datagrid[name]
				}
			},
			init:function(url,filter,sort){
				$scope._datagrid.clear();
				$scope._datagrid.url=url;
				$scope._datagrid.filter=$scope._merge($scope._datagrid.filter,filter);
				$scope._datagrid.sort=$scope._merge($scope._datagrid.filter,sort);
				if(angular.isDefined(arguments[3])){
					$scope._datagrid.visible=arguments[3]?!0:!1
				}
			},
			load:function(){
				var callback=angular.isFunction(arguments[0])?arguments[0]:null;
				$scope._loader('show');
				var params={
					datagrid:1,filter:$scope._datagrid.filter,sort:$scope._datagrid.sort,page:$scope._datagrid.page,view:$scope._datagrid.view,_rand:Math.random()
				};
				$scope._data.get(
					$scope._datagrid.url+'?'+angular.element.param(params),
					function(datagrid){
						if(!angular.isDefined(datagrid.columns)){
							$scope._showError('Terjadi Masalah !','Data tidak dapat dibaca.');
						return
					};
						for(var i in datagrid.columns){
							datagrid.columns[i].sort='';
							if(datagrid.sort.by==datagrid.columns[i].property){
								datagrid.columns[i].sort=datagrid.sort.dir
							}
						}
						$scope._datagrid.set(datagrid)angular.element('.datagrid .ui.dropdown').dropdown('set selected',$scope._datagrid.view);
						if(callback!=null){
							callback()
						}
						else{
							$scope._loader('hide')
						}
					}
				)
			},
			action:{
				filter:function(){
					$scope._datagrid.page=1;
					$scope._datagrid.load()
				},
				sort:function(index){
					if(!angular.isDefined($scope._datagrid.columns[index].sortable)||$scope._datagrid.columns[index].sortable!=!0)return !1;
					var property=$scope._datagrid.columns[index].property;
					for(var i in $scope._datagrid.columns){
						if($scope._datagrid.columns[i].property==property){
							if($scope._datagrid.sort.by==property){
								$scope._datagrid.sort.dir=$scope._datagrid.sort.dir=='asc'?'desc':'asc'
							}
							else{
								$scope._datagrid.sort.by=property;$scope._datagrid.sort.dir='asc'
							}
							break
						}
					}
					if($scope._datagrid._sortCallback!=null){
						$scope._datagrid._sortCallback($scope._datagrid.sort)
					}
					$scope._datagrid.load()
				},
				page:function(page){
					if(page<1)return;
					$scope._datagrid.page=page;
					$scope._datagrid.load()
				},
				view:function(view){
					$scope._datagrid.page=1;
					$scope._datagrid.view=view;
					$scope._datagrid.load()
				},
				delete:function(url,name){
					$scope._delete.action({name:name,url:url},function(params){
						$scope._loader('show');
						$scope._data.delete(params.url,function(){
							$scope._datagrid.load()
						})
					})
				}
			}
		};
		$scope._model={clear:function(){
			for(var name in $scope._model){
				if(angular.isFunction($scope._model[name]))continue;
				delete($scope._model[name])
			}
		},
		set:function(model){
			for(var name in model){
				if(angular.isFunction($scope._model[name]))continue;
				$scope._model[name]=model[name]
			}
		}
	};
	$scope._delete={
		name:'',
		params:{},
		confirmAction:null,
		cancelAction:null,
		init:function(){
			var modal=angular.element('.ui.dimmer.modals #delete-modal');
			if(!modal.size()){
				angular.element('#delete-modal').modal({
					selector:{close:'.close'},
					onVisible:function(){
						angular.element(this).modal('refresh')
					}
				})
			}
		},
		action:function(params,confirmAction){
			$scope._delete.init();
			$scope._delete.name=angular.isDefined(params.name)?params.name:'';
			$scope._delete.params=params;
			$scope._delete.confirmAction=confirmAction;
			$scope._delete.cancelAction=angular.isFunction(arguments[2])?arguments[2]:null;
			angular.element('#delete-modal').modal('show')
		},
		confirm:function(){
			angular.element('#delete-modal').modal('hide');
			if(angular.isFunction($scope._delete.confirmAction)){
				$scope._delete.confirmAction($scope._delete.params)
			}
		},
		cancel:function(){
			angular.element('#delete-modal').modal('hide');
			if(angular.isFunction($scope._delete.cancelAction)){
				$scope._delete.cancelAction($scope._delete.params)
			}
		}
	};
	$scope._render=function(){
		angular.element('.page-sidebar').sidebar({
			closable:!1,dimPage:!1,onVisible:function(){
				if($scope._viewport!='desktop'){
					angular.element('.page-wrapper').dimmer('show')
				}
			},
			onShow:function(){
				angular.element('.page-wrapper, .page-bar').addClass('shrink')
			},
			onHide:function(){
				angular.element('.page-wrapper, .page-bar').removeClass('shrink');
				if($scope._viewport!='desktop'){
					angular.element('.page-wrapper').dimmer('hide')
				}
			}
		}).sidebar('attach events','.btn-sidebar-toggle');
		angular.element('.page-bar .ui.dropdown').dropdown();
		angular.element('.popup-toggle').popup({preserve:!0})angular.element('.sidebar-menu').accordion()};
		$scope._init()
	}
])
.directive('serviceParameter',['$compile',function($compile){return{restrict:'A',transclude:!1,link:function(scope,element,attrs){var type=attrs.serviceParameter;var template=type;if(type=='ejournal_ebsco_host'||type=='ejournal_proquest'){template='username_password'}
if(type=='ejournal_cencage_learning'){template='password'}
if(type=='google_mail'||type=='google_mail_sub'||type=='google_mail_faculty'){template='google_mail'}
var find=angular.element('.page-content #'+template+'-template');if(find.size()){element.html(find.html()).show();$compile(element.contents())(scope)}}}}]).directive('validationItemTemplate',['$compile',function($compile){return{restrict:'A',transclude:!1,link:function(scope,element,attrs){var template=attrs.validationItemTemplate;var find=angular.element('.page-content #'+template);if(find.size()){element.html(find.html()).show();$compile(element.contents())(scope)}}}}]).directive('validationItemAttributeTemplate',['$compile',function($compile){return{restrict:'A',transclude:!1,link:function(scope,element,attrs){var data=scope._find.data(scope.attributes,{attribute_slug:attrs.validationItemAttributeTemplate});if(data.length<1)return;var template='attr-';if(data[0].is_multi_value){template+='multi-value'}
else{if(data[0].is_option){template+='option';if(data[0].is_grouped_option){template+='-group'}}
else if(data[0].is_date){template+='date'}
else{template+='text'}}
template+='-template';var find=angular.element('.page-content #'+template);if(find.size()){element.html(find.html()).show();$compile(element.contents())(scope)}}}}]).directive('userRegistrationField',['$compile',function($compile){return{restrict:'A',transclude:!1,link:function(scope,element,attrs){for(var i in scope._action.registration.attributes){var data=scope._find.data(scope._action.registration.attributes[i],{attribute_id:attrs.userRegistrationField});if(data.length)break}
if(data.length<1)return;var template='reg-';if(data[0].is_option){template+='option';if(data[0].is_grouped_option){template+='-group'}}
else if(data[0].is_date){template+='date'}
else{template+='text'}
if(data[0].is_required){template+='-required'}
template+='-template';var find=angular.element('.page-content #'+template);if(find.size()){element.html(find.html()).show();$compile(element.contents())(scope)}}}}]).directive('ngEditor',['$compile','$timeout',function($compile,$timeout){return{restrict:'A',link:function(scope,$element,attrs,ctrl){scope.cursorStyle={};scope.execCommand=function(cmd,arg){scope.$emit('execCommand',{command:cmd,arg:arg})};scope.$on('cursor-position',function(event,data){scope.cursorStyle=data})},scope:{content:'='},replace:!0,template:['<div>','	<div class="ui basic fitted top attached segment">','		<div class="ui buttons">','			<div ng-click="execCommand(\'bold\')" class="ui blue icon button" ng-class="{active: cursorStyle.bold}"><i class="bold icon"></i></div>','			<div ng-click="execCommand(\'italic\')" class="ui blue icon button" ng-class="{active: cursorStyle.italic}"><i class="italic icon"></i></div>','			<div ng-click="execCommand(\'underline\')" class="ui blue icon button" ng-class="{active: cursorStyle.underline}"><i class="underline icon"></i></div>','		</div>','		<div class="ui buttons">','			<div ng-click="execCommand(\'justifyleft\')" class="ui blue icon button" ng-class="{active: cursorStyle.alignment == \'left\'}"><i class="align left icon"></i></div>','			<div ng-click="execCommand(\'justifycenter\')" class="ui blue icon button" ng-class="{active: cursorStyle.alignment == \'center\'}"><i class="align center icon"></i></div>','			<div ng-click="execCommand(\'justifyright\')" class="ui blue icon button" ng-class="{active: cursorStyle.alignment == \'right\'}"><i class="align right icon"></i></div>','			<div ng-click="execCommand(\'justifyfull\')" class="ui blue icon button" ng-class="{active: cursorStyle.alignment == \'justify\'}"><i class="align justify icon"></i></div>','		</div>','		<div class="ui buttons">','			<div ng-click="execCommand(\'insertunorderedlist\')" class="ui blue icon button"><i class="list icon"></i></div>','			<div ng-click="execCommand(\'insertorderedlist\')" class="ui blue icon button"><i class="ordered list icon"></i></div>','		</div>','		<div class="ui buttons">','			<div ng-click="execCommand(\'outdent\')" class="ui blue icon button"><i class="indent icon"></i></div>','			<div ng-click="execCommand(\'indent\')" class="ui blue icon button"><i class="outdent icon"></i></div>','		</div>','	</div>','	<div class="ui attached segment" style="background: #f7f7f7;">','		<textarea ng-model="content" style="display: none;"></textarea>','		<iframe ng-editor-frame style="border:0; width: 100%; height: 100%;" ng-model="content"></iframe>','	</div>','</div>'].join('')}}]).directive('ngEditorFrame',['$compile','$timeout',function($compile,$timeout){return{restrict:'A',link:function(scope,$element,attrs,ctrl){var $document=$element[0].contentDocument;$document.open();$document.write('<!DOCTYPE html><html><head><link href="assets/semantic/semantic.min.css" rel="stylesheet" type="text/css" media="screen" /></head><body contenteditable="true"></body></html>');$document.close();$document.designMode='On';var $body=angular.element($element[0].contentDocument.body);var $head=angular.element($element[0].contentDocument.head);$body.attr('contenteditable','true');ctrl.$render=function(){$body[0].innerHTML=ctrl.$viewValue||''};scope.sync=function(){scope.$evalAsync(function(scope){ctrl.$setViewValue($body.html())})};var getSelectionBoundaryElement=function(win,isStart){var range=null;var sel=null;var container=null;var doc=win.document;if(doc.selection){range=doc.selection.createRange();range.collapse(isStart);return range.parentElement()}
else if(doc.getSelection){sel=doc.getSelection();if(sel.rangeCount>0){range=sel.getRangeAt(0);container=range[isStart?"startContainer":"endContainer"];if(container.nodeType===3){container=container.parentNode}}}
else if(win.getSelection){sel=win.getSelection();if(sel.rangeCount>0){range=sel.getRangeAt(0);container=range[isStart?"startContainer":"endContainer"];if(container.nodeType===3){container=container.parentNode}}}
return container};var debounce=null;$body.bind('blur click keyup change paste',function(){if(debounce){$timeout.cancel(debounce)}
debounce=$timeout(function blurkeyup(){ctrl.$setViewValue($body.html());var el=getSelectionBoundaryElement($element[0].contentWindow,!0);if(el){var computedStyle=$element[0].contentWindow.getComputedStyle(el);var elementStyle={'bold':(computedStyle.getPropertyValue("font-weight")=='bold'||parseInt(computedStyle.getPropertyValue("font-weight"))>=700),'italic':(computedStyle.getPropertyValue("font-style")=='italic'),'underline':(computedStyle.getPropertyValue("text-decoration")=='underline'),'alignment':computedStyle.getPropertyValue("text-align")}
scope.$emit('cursor-position',elementStyle)}},100,!0)});scope.$on('execCommand',function(e,cmd){$element[0].contentDocument.body.focus();var sel=$document.selection;if(sel){var textRange=sel.createRange();$document.execCommand(cmd.command,0,cmd.arg);textRange.collapse(!1);textRange.select()}
else{$document.execCommand(cmd.command,0,cmd.arg)}
$document.body.focus();scope.sync()})},replace:!0,require:'ngModel'}}])