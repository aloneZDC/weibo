/**
 * Antvel - App Angular Js Functions
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

(function(){
'use strict';
var app=angular.module('AntVel');

app.controller('PushNotificationsController', function($scope, $http, $location)
{
	var query = function()
	{
		$http
			.get('/push', { ignoreLoadingBar: true  })
			.success(function(data) {
				$scope.hasNotifications = data.unread.length || data.read.length;
				$scope.unread = data.unread;
				$scope.read = data.read;
			}).finally(function() {
				setTimeout(function() { query(); }, 5000);
			});
	};

	query();
});

// Auto Complete Busqueda general
app.controller('AutoCompleteCtrl', function($scope,$http,$location) {

	//sending form
	$scope.selectedItem = function(result){

		if ('undefined' !== typeof result && result.kind === 'suggestions') {

			window.location = '/products/' + result.originalObject.id;

		}else if('undefined' !== typeof result && result.kind === 'categories'){

			$location.search(
				'category',
				encodeURI(result.originalObject.id + '|' + result.title)
			);

			$location.path('/products/');
            window.location = $location.absUrl();

		}else{

			$('#search_value').val(result.title);
			$('#searchForm').submit();
		}
	};
});

//Dialogos Modales
app.controller('ModalCtrl', function($scope, $uibModal){
	var modalInstance = null;
	$scope.data = {};
	$scope.modalOpen = function (opts) {
		if( opts.resolve === '' || opts.resolve === null ){
			opts.resolve = 'data';

		}

		var obj= {},literal = opts.resolve;
		obj[literal] = function (){ return $scope.data; };

		var modalInstance = $uibModal.open({

			templateUrl: opts.templateUrl+(opts.noCache?'?'+Math.random():'') || null,

			template: opts.template || null,

			controller: opts.controller,

			size: opts.size || 'lg',

			resolve: obj
		});

	};
})
.directive('stopEvent', function () {
	return {
		restrict: 'A',
		link: function (scope, element, attr) {
			element.on(attr.stopEvent, function (e) {
				e.stopPropagation();
			});
		}
	};
});

//Control de login
app.controller('LoginController',['$scope','$http',function($scope, $http){
	$scope.havePassword = true;

	$scope.setHavePassword = function(status){
		$scope.havePassword = status;
	};
}]);

//Control de categorias

/**
 * Categories Controller
 * Save the selected category into "category" hidden, in order to use it in the search
 */
app.controller('CategoriesController',['$scope','$http',function($scope, $http)
{
	/**
	 * catSelected
	 * Category var model
	 */
	$scope.catSelected = {};

	/**
	 * refine
	 * assign the category info to form hidden named "category"
	 */
	$scope.refine = function()
	{
		return $scope.catSelected.id ? $scope.catSelected.id+'|'+$scope.catSelected.name :'';
	};

	/**
	 * setCategorie
	 * assign the category info to Category var model
	 * @param {int} id category id
	 * @param {string} cat category name
	 */
	$scope.setCategorie = function(id, cat){
		$scope.catSelected.name = cat;
		$scope.catSelected.id = id;
	};
}]);

//Control for rate Angular UI Rate
app.controller('RatingCtrl', function ($scope) {
    $scope.max = 5;
});
//Control de WishList
app.controller('WishListControllerModal', function($scope, $http, $rootScope,$uibModalInstance){
    $scope.newList = {};

    $scope.createList = function(productId){
        if($scope.newList.description){
            $http.post('/wishes/store', $scope.newList).
                success(function(data, status) {
                    if (data.success) {
                        //$rootScope.allLists.push(data.newList);
                        console.log(data);
                        $uibModalInstance.close();
                        if(productId){
                        	window.location.replace('/products/'+productId);
                        }else{
                        	window.location.replace('/wishes/directory');
                        }
                    }else{
                        console.log(data); //mensajes de error
                    }
                }).
                error(function(data, status, headers, config) {
                    $rootScope.allLists.pop();
                    console.log(data);
                });
            console.log($scope.newList);
        }else{
            console.log($scope.newList);
        }
        //$uibModalInstance.close();
    };
});

/**
 * PassInfo
 * Services to pass a var between controllers
 */
app.service('PassInfo', function ()
{
       	var property = '';

        return {
            getProperty: function ()
            {
                return property;
            },

            setProperty: function(value)
            {
                property = value;
            }
        };
});

//Control de Direcciones
app.controller('AddressesControllerModal', function($scope, $http, $rootScope, $uibModalInstance, notify, $window, PassInfo){

	/**
	 * auxCallBack
	 * it is the scope bettwen address list and the modal. auxCallBack contains the callback url, so the controller
	 * knows where to gos after process either a update or a insert
	 * @type {[type]}
	 */
	var auxCallBack = PassInfo.getProperty();

	/**
	 * _address
	 * it is the model to be used either in the update or insert process
	 * @type {Object}
	 */
	$scope._address = {};

	/**
	 * getCountries
	 * this method retrieves the countries information from restcountries.eu
	 * @return [json] countries list
	 */
	$scope.getCountries = function()
	{
		$http.get('https://restcountries.eu/rest/v1/all')
			.success(function(data, status)
			{
				$scope.countries = data;
			});
	};

	$scope.getCountries();

	$scope.create = function()
	{
		$http.post('/addressBook', $scope._address).
			success(function(data, status)
			{
				if (data.success)
				{
					$uibModalInstance.close();
					$window.location.href = auxCallBack != '' ? auxCallBack : data.callback;
				}

				else
				{
					notify({ duration: 5000, messageTemplate:'<p>'+data.message+'</p>', classes: data.class });
				}
			});
	};

	$scope.update = function(){

		$http.put('/addressBook/' + $scope._address.id, $scope._address).

			success(function(data, status) {

				if (data.success)
				{
					$uibModalInstance.close();
					$window.location.href = auxCallBack != '' ? auxCallBack : data.callback;
				}

				else
				{
					notify({ duration: 5000, messageTemplate:'<p>'+data.message+'</p>', classes: data.class });
				}
			});
	};

});

app.controller('getKeysVirtualProducts',function($scope,$http,data){
    $scope.keys=[];
    $scope.message='';
    $scope.class='alert-danger';
    $scope.show=false;
    $scope.thisShow=true;
    $http.get('/showAllKeys/'+data.data).success( function(data) {
        if (data.message){
            $scope.message=data.message;
    		$scope.show=true;
        }else $scope.keys=data;
    });
    $scope.change=function(id){
    	$http.get('/deleteKey/'+id).success( function(data) {
        	if (data.message)
	        	$scope.message=data.message;
	        else{
	        	$scope.message=data.success;
			    $scope.class='alert-success';
	        }
    		$scope.show=true;
    		$scope.thisShow=true;
	    });
    };
});
app.controller('getDetailsProductInCart',function($scope,$http,data){
	$scope.product=[];$scope.order=[];$scope.per=false;
    $scope.virtual=false; $scope.message='';
    $scope.class='alert-danger';
    $scope.show=false;
    $scope.thisShow=true;
    $http.get('/showDetailsProductCart/'+data.data).success( function(data) {
        if (data.message){
            $scope.message=data.message;
    		$scope.show=true;
        }else{
        	$scope.per=true;
        	$scope.product=data.product;
        	$scope.order=data.order;
        	if (data.virtual){
        		$scope.virtual=data.virtual;
        	}
        }
    });
    var changeKey=function(email,action){

    	var obj=false;
    	if (action=='all'){
    		obj={'email':email,'delete':true};
    	}
    	else if(action==1){
    		obj={'email':email,'increment':true};
    	}
    	else if(action==-1){
    		obj={'email':email,'decrement':true};
    	}

    	if (obj){
	    	$http.post('/editKeyVirtualProductsOrders/'+data.data,obj).success(function(data) {
	    		if (data.message){
		            $scope.message=data.message;
		    		$scope.show=true;
		        }else{
		        	if (data.all) document.getElementById(email).style.display='none';
		        	else{
		        		document.getElementById(email).children[0].children[0].innerHTML=data.num;
		        		console.log(document.getElementById(email).children[0].children);
		        		// document.querySelector("#"+email).innerHTML=data.num;
		        	}
		        }
		    });
    	}
    };
    $scope.increaseKey= function(email){ changeKey(email,1); };
    $scope.decrementKey= function(email){ changeKey(email,-1); };
    $scope.removeKey= function(email){ changeKey(email,'all'); };
    $scope.change=function(id){
    	$http.get('/deleteKey/'+id).success( function(data) {
        	if (data.message)
	        	$scope.message=data.message;
	        else{
	        	$scope.message=data.success;
			    $scope.class='alert-success';
	        }
    		$scope.show=true;
    		$scope.thisShow=true;
	    });
    };
});
app.controller('seeKeysPurchased',function($scope,$http,data){
	$scope.info=[];
	$scope.detail=[];
    $http.get('/user/showKeyVirtualProductPurchased/'+data.data+'/'+data.order).success( function(data) {
        console.log(data);
        if (data.message){
            $scope.message=data.message;
    		$scope.show=true;
        }else{
        	$scope.info=data.info;
        	$scope.details=data.users;
        }
    });
});


/**
 * Users points push notification
 */
app.controller('PushUsersPoints', ['$scope', '$http', '$interval', function($scope, $http, $interval)
{
	$scope.points = '';
	$scope.pusher = function()
	{
		$http.get('getPoints', { ignoreLoadingBar: true } ).success(function(data)
        {
        	if (data.points) {
        		$scope.points = data.points;

        	}
        });
	};

	$interval(function(){ $scope.pusher(); }, 60000);

}]);

app.controller('ProductBox', ['$scope', '$window', function($scope, $window)
{

	$scope.goTo = function (url)
    {
        $window.location.href = url;
    };

    $scope.submit = function(id) {
        $(id).submit();
    };

}]);

app.controller('DataPickerCtrl', function($scope)
{
  	$scope.open = function($event)
  	{
    	$scope.status.opened = true;
  	};

	$scope.status =
	{
		opened: false
	};

	$scope.open2 = function($event)
  	{
    	$scope.status2.opened = true;
  	};

	$scope.status2 =
	{
		opened: false
	};
});

})(); //modules
