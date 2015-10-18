$(function () {
    G.logic.map = {
        op: {
            lat: 31.308563,
            lng: 121.525808,
            adr: "上海市杨浦区政益路28号",
            type: "baidu"
        },
        el: {
            lat: $("#lat"),
            lng: $("#lng"),
            suggestId: $("#suggestId")
        },
        maps: null,
        is_default: true,
        is_change: false,
        baidu: {
            point: null,
            marker: null,
            infowindow: null,
            map: null,
            load: function () {
                if (typeof (BMap) == 'undefined') {
                    var script = document.createElement("script");
                    script.src = "http://api.map.baidu.com/api?v=2.0&ak=359042E5AC9ced07c553ebe2042aad73&callback=G.logic.map.baidu.init";
                    document.body.appendChild(script);
                } else {
                    this.init();
                }

            },
            init: function (op) {
                var self = this;
                self.map = new BMap.Map("l-map");
                self.point = new BMap.Point(G.logic.map.op.lng, G.logic.map.op.lat);
                self.map.centerAndZoom(self.point, 15);
                self.map.enableScrollWheelZoom();
                self.map.enableScrollWheelZoom();

                self.marker = new BMap.Marker(self.point);
                self.map.addOverlay(self.marker);



                self.map.addEventListener("dragend", function showInfo() {
                    self.marker.closeInfoWindow();
                    self.showAddress(self.marker);
                });

                self.map.addEventListener("dragging", function showInfo() {
                    var cp = self.map.getCenter();
                    self.marker.setPosition(new BMap.Point(cp.lng, cp.lat));

                });
                self.marker.enableDragging();
                self.marker.addEventListener("click", function (e) {
                    this.openInfoWindow(self.infoWindow);
                });
                self.marker.addEventListener("dragend", function (e) {
                    self.marker.closeInfoWindow();
                    self.showAddress(self.marker);
                });

                var opts = { width: 220, height: 80, title: "原本位置" };
                self.infoWindow = new BMap.InfoWindow(" " + G.logic.map.op.adr + " ,拖拽地图或红点修改位置!你也可以直接修改上方位置系统自动定位!", opts);  // 创建信息窗口对象
                if (!G.logic.map.is_change) {
                    self.marker.openInfoWindow(self.infoWindow);
                } else {
                    self.search();
                }
                if (G.logic.map.is_default) {
                    window.setTimeout(function () {
                        self.locate();
                    }, 1000);
                }

            },
            locate: function () {
                var self = this;
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function (r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        point = new BMap.Point(r.point.lng, r.point.lat);
                        self.marker.setPosition(point);
                        self.map.panTo(point);
                        var opts = { width: 220, height: 60, title: "定位成功" };
                        self.infoWindow = new BMap.InfoWindow("这是你当前的位置!,移动红点标注目标位置，你也可以直接修改上方位置,系统自动定位!", opts);  // 创建信息窗口对象
                        self.marker.openInfoWindow(self.infoWindow);
                        self.showAddress(self.marker, true);

                    } else {
                        console.log("无法获取定位");
                    }
                });
            },
            search: function () {
                var self = this;
                var myGeo = new BMap.Geocoder();
                var addr = G.logic.map.el.suggestId.val();
                addr = addr.length > 0 ? addr : G.logic.map.op.adr;
                myGeo.getPoint(addr, function (point) {
                    if (point) {
                        self.marker.setPosition(point);
                        self.map.panTo(point);
                        var opts = { width: 220, height: 60, title: "搜索位置" };
                        self.infoWindow = new BMap.InfoWindow("" + addr + ",移动红点标注目标位置，你也可以直接修改上方位置,系统自动定位!", opts);  // 创建信息窗口对象
                        self.marker.openInfoWindow(self.infoWindow);      // 打开信息窗口
                        // map.centerAndZoom(self.marker.getPosition(), self.map.getZoom());
                        self.showAddress(self.marker, true);
                    } else {
                        console.log("Search no point");
                    }
                }, "全国");
            },
            showAddress: function (marker, callout) {
                var latlng = marker.getPosition();
                var self = this;
                var myGeo = new BMap.Geocoder();
                myGeo.getLocation(latlng, function (result) {
                    if (result) {
                        document.getElementById('suggestId').value = result.address;
                        var el = G.logic.map.el;
                        el.lat.val(latlng.lat);
                        el.lng.val(latlng.lng);
                        el.suggestId.val(result.address);
                        if (!callout) {
                            var opts = { width: 220, height: 80, title: "标注位置" };
                            self.infoWindow = new BMap.InfoWindow(" " + result.address + " ,拖拽地图或红点修改位置!你也可以直接修改上方位置系统自动定位!", opts);
                            //self.marker.openInfoWindow(self.infoWindow);
                        }

                    } else {
                        console.log("无法获取定位");
                    }
                });
            }

        },
        google: {
            point: null,
            marker: null,
            infowindow: null,
            map: null,
            load: function () {
                if (typeof (google) == 'undefined') {
                    var script = document.createElement("script");
                    var keys = ["AIzaSyAOne2X4zK1sQPbsiSK6oSaF8U7BJkPmt0", "AIzaSyBSvfDvgbHw88c3HOG2lWP5A4bDnu6oPVI", "AIzaSyDpx3CSeFhC9V0FZ8A5BLIIsfOpiRpuDhM"];
                    script.src = "http://maps.googleapis.com/maps/api/js?key={0}&sensor=false&callback=G.logic.map.google.init".format(keys[Math.floor(Math.random() * keys.length + 1) - 1]);
                    document.body.appendChild(script);
                } else {
                    this.init();
                }
            },
            init: function () {
                var self = this;
                self.point = new google.maps.LatLng(G.logic.map.op.lat, G.logic.map.op.lng);
                var myOptions = {
                    zoom: 15, // 缩放级别
                    center: self.point,
                    mapTypeId: google.maps.MapTypeId.ROADMAP, // 显示普通的街道地图
                    mapTypeControl: false, // 地图类型控件
                    overviewMapControl: true, // 总览图控件
                    scaleControl: false, // 比例控件
                    streetViewControl: false, // 街景视图
                    panControl: true//平移控件

                };

                self.map = new google.maps.Map(document.getElementById("l-map"), myOptions);

                self.marker = new google.maps.Marker({
                    position: self.point,
                    map: self.map
                });
                self.marker.setDraggable(true); // 设置可拖拽
                self.map.addListener("drag", function () {
                    var cp = self.map.center;
                    self.marker.setPosition(cp);
                });
                self.map.addListener("dragend", function () {
                    self.infowindow.close();
                    self.showAddress(self.marker);
                });
                //初始化信息窗口
                self.infowindow = new google.maps.InfoWindow();

                google.maps.event.addListener(self.marker, 'dragend', function () {
                    self.infowindow.close();
                    self.showAddress(self.marker);
                });
                google.maps.event.addListener(self.marker, 'click', function () {
                    self.infowindow.open(self.map, self.marker);
                    // self.showAddress(self.marker);
                });
                self.infowindow = new google.maps.InfoWindow({
                    content: "<div style='width:180px'>原本位置 {0} ,移动红点修改位置!你也可以直接修改上方位置系统自动定位!</div>".format(G.logic.map.op.adr)
                });

                if (!G.logic.map.is_change) {
                    self.infowindow.open(self.map, self.marker);
                } else {
                    self.search();
                }

                if (G.logic.map.is_default) {
                    self.locate();
                }
            },
            locate: function () {
                var self = this;
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        var al = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        self.marker.setPosition(al);
                        self.map.panTo(al);
                        self.infowindow.setContent("<div style='width:200px'>定位成功这是你当前的位置!,移动红点标注目标位置，你也可以直接修改上方位置,系统自动定位!</div>");
                        self.infowindow.open(self.map, self.marker);
                        self.showAddress(self.marker, true);
                    });
                }
            },
            search: function () {
                var self = this;
                var geocoder = new google.maps.Geocoder();
                var addr = G.logic.map.el.suggestId.val();
                addr = addr.length > 0 ? addr : G.logic.map.op.adr;
                geocoder.geocode({ address: addr }, function geoResults(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var al = results[0].geometry.location;
                        self.infowindow.setContent("<div style='width:200px'>搜索位置 " + results[0].formatted_address + " ,移动红点修改位置!你也可以直接修改上方位置系统自动定位!</div>")
                        self.infowindow.open(self.map, self.marker);
                        self.marker.setPosition(al);
                        self.map.panTo(al);
                        self.showAddress(self.marker, true);
                    }
                });
            },
            showAddress: function (marker, callout) {
                var latlng = marker.getPosition();
                var geocoder = new google.maps.Geocoder();
                var self = this;
                //根据经纬度获取地址信息
                geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            var formatted_address = results[0].formatted_address;
                            var addr_str_length = formatted_address.indexOf("邮政编码");
                            if (addr_str_length > 0) {
                                formatted_address = (formatted_address.substring(0, addr_str_length));
                            }
                            if (!callout) { self.infowindow.setContent("<div style='width:190px'>标注位置 " + formatted_address + " ,移动红点修改位置!你也可以直接修改上方位置系统自动定位!</div>"); };
                            var el = G.logic.map.el;
                            el.lat.val(latlng.lat());
                            el.lng.val(latlng.lng());
                            el.suggestId.val(formatted_address);
                        }
                    } else {
                        console.log("Geocoder failed due to: " + status);
                    }
                });
            }
        },
        tencent: {
            point: null,
            marker: null,
            infowindow: null,
            map: null,
            geocoder: null,
            load: function () {
                if (typeof (qq) == 'undefined') {
                    var script = document.createElement("script");
                    script.src = "http://map.qq.com/api/js?v=2.exp&key=JZSBZ-ZI4RF-HRCJY-JN3OW-V37KS-SOB4K&callback=G.logic.map.tencent.init";
                    document.body.appendChild(script);
                } else {
                    this.init();
                }

            },
            init: function (op) {
                var self = this;
                self.point = new qq.maps.LatLng(G.logic.map.op.lat, G.logic.map.op.lng);
                self.map = new qq.maps.Map(document.getElementById("l-map"), {
                    center: self.point,
                    zoom: 15
                });

                self.infowindow = new qq.maps.InfoWindow({
                    map: self.map,
                    position: self.point,
                    content: " <div style='width:200px'>原本位置 {0} ,拖拽地图或红点修改位置!你也可以直接修改上方位置系统自动定位!</div>".format(G.logic.map.op.adr)
                });
                self.marker = new qq.maps.Marker({
                    position: self.point,
                    draggable: true,
                    map: self.map
                });
                qq.maps.event.addListener(self.map, 'drag', function () {
                    var p = self.map.getCenter();
                    self.marker.setPosition(p);

                });
                qq.maps.event.addListener(self.map, 'dragend', function () {
                    var p = self.map.getCenter();
                    self.infowindow.close();
                    self.showAddress(p);
                });
                qq.maps.event.addListener(self.marker, 'dragend', function () {
                    var p = self.marker.getPosition();
                    self.showAddress(p);
                    self.infowindow.close();

                });
                qq.maps.event.addListener(self.marker, 'click', function () {
                    self.infowindow.open();
                });
                if (self.geocoder == null) {
                    self.geocoder = new qq.maps.Geocoder();
                }
                ///同步infowindow
                qq.maps.event.addListener(self.marker, 'position_changed', function () {
                    var p = self.marker.getPosition();
                    self.infowindow.setPosition(p);
                });

                if (!G.logic.map.is_change) {
                    self.infowindow.open();
                } else {
                    self.search();
                }
                if (G.logic.map.is_default) {
                    window.setTimeout(function () {
                        self.locate();
                    }, 1000);
                }

            },

            setval: function (result) {
                var self = this;
                var p = result.detail.location, addr = result.detail.address;
                self.marker.setPosition(p);
                self.map.panTo(p);
                var el = G.logic.map.el;
                el.lat.val(p.lat);
                el.lng.val(p.lng);
                el.suggestId.val(addr);
            },
            locate: function () {
                var self = this;
                navigator.geolocation.getCurrentPosition(function (position) {
                    var p = new qq.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    self.map.panTo(p)
                    self.marker.setPosition(p);
                    self.infowindow.setContent("<div style='width:200px'>定位成功这是你当前的位置!,移动红点标注目标位置，你也可以直接修改上方位置,系统自动定位!</div>");
                    self.infowindow.open();
                    self.rgeocoder().getAddress(p);
                });

            },
            search: function () { 
                var self = this;
                var addr = G.logic.map.el.suggestId.val();
                addr = addr.length > 0 ? addr : G.logic.map.op.adr;
                self.geocoder.getLocation(addr);
                self.geocoder.setComplete(function (result) {
                    self.setval(result);
                    self.infowindow.open();
                    self.infowindow.setContent("<div style='width:200px'>搜索位置 {0} ,移动红点修改位置!你也可以直接修改上方位置系统自动定位!</div>".format(result.detail.address))
                })

            },
            showAddress: function (p) {
                var self = this;
                self.geocoder.getAddress(p);
                self.geocoder.setComplete(function (result) {
                    self.setval(result);
                    self.infowindow.setContent("<div style='width:200px'>标注位置 {0} ,移动红点修改位置!你也可以直接修改上方位置系统自动定位!</div>".format(result.detail.address))
                })
            }

        },
        _type: function () {
            return $(":radio[name='map_type']:checked").data("mapty");
        },
        init: function (op) {
            var self = this;
            if (op) { self.op = op; self.is_default = false; };
            self.op.type = self._type();
            self.maps = this[this.op.type];
            self.maps.load();
            var positioning = $("#positioning");
            positioning.click(function () {
                self.maps.search();
            });
            $(":radio[name='map_type']").on("click", function (e) {
                G.logic.map.is_change = true;
                self.op.type = self._type();
                self.maps = self[self.op.type];
                $("#l-map").css("background-color", "white").html("<div class='loading'>地图加载中...</div>")
                self.maps.load();
            })
        }
    }
})