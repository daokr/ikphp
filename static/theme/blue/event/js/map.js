IK(function() {
	var e;
	var a = window._pinicon_;
	var i = '<span id="map-tip">拖动红色图标以标记 </span><span id="map-btns" class="hidden"><a class="lnk-flat map-save" href="javascript:void(0);">保存</a>&nbsp;&nbsp;<a class="lnk-flat map-cancel" href="#">取消</a></span>';
	var d = "http://maps.google.cn/maps/api/staticmap?size=388x106&zoom=13&markers=icon:" + a + "|{coordinate}&sensor=false&language=zh-CN";
	var k = dui.Dialog({
		title: "标注地图",
		width: "600",
		cache: true,
		iframe: true,
		isHideTitle: true,
		content: '<div id="map-search-container"><div id="search-control"><div id="search-control-ui"><input type="text" name="q-address" id="q-address" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"><input type="button" id="btn-search" value="查找"></div></div></div><div id="mapWrapper"></div><div class="map-footer">' + i + "</div>"
	},
	true);
	var c = google.maps.event.addListener;
	k.node.bind("dialog:close",
	function(m) {
		m.preventDefault()
	});
	k.node.delegate(".map-save", "click",
	function(p) {
		p.preventDefault();
		if (!e) {
			return
		}
		var r = e.position;
		var q = r.toUrlValue();
		var m;
		var n;
		if (e.actionType === "known_address") {
			m = $("#selected_known_address").data("coordinate", q).val(q).prevAll("a").find("img");
			n = m.parents(".map-card")
		} else {
			n = $("#new-map-card");
			m = n.find("img");
			var o = new google.maps.Geocoder();
			o.geocode({
				location: r
			},
			function(u, s) {
				if (!s || s != "OK") {
					return
				}
				var x = u[0].address_components;
				var v = "";
				$.each(x,
				function(t, y) {
					var A = y.long_name || "";
					if (A && y.types[0] == "sublocality") {
						var z = $("#district_id");
						if (!+z.val()) {
							z.children().each(function(B, C) {
								if (C.innerHTML.indexOf(A) != -1) {
									C.selected = "selected";
									IK.updateCity($("#loc_id").val(), C.value);
									return false
								}
							})
						}
						return false
					} else {
						v = A + v
					}
				});
				var w = $("#street_address");
				v && !$.trim(w.val()) && w.val(v)
			})
		}
		$("#coordinate").val(q);
		n.find(".map-card-nomark").remove();
		n.find(".map-card-modify").show();
		m.attr("src", d.replace("{coordinate}", q));
		k.close()
	}).delegate(".map-cancel", "click",
	function(m) {
		m.preventDefault();
		k.close()
	});
	function h(p, o, m) {
		o = o || {};
		var n = o.latLng || o.toLatLng && new google.maps.LatLng(o.toLatLng.lat, o.toLatLng.lng) || p.center;
		e = dui.iMap.createMarker(p, {
			draggable: true,
			latLng: n,
			icon: {
				url: a,
				size: [13, 27]
			}
		});
		e.actionType = m;
		p.setCenter(n);
		if ("zoom" in o) {
			p.setZoom(o.zoom)
		}
		c(e, "dragend", l)
	}
	function l(o) {
		var n = this.map || this;
		var m = o && o.latLng || n.center;
		n.setCenter(m);
		if (!o && e && !j(n, e)) {
			e.setPosition(m)
		}
		if (o || n.getZoom() > 11) {
			g()
		}
	}
	function j(n, m) {
		return m && n.getBounds().contains(m.position)
	}
	function b(C, t) {
		C = C || {};
		var x = $("#mapWrapper"),
		G = $('<div id="mapInner"></div>'),
		w = $("#district_id"),
		s = $("#region_id"),
		E = $("#city"),
		z = $("#q-address"),
		r = $.trim(C.loc_name) || $.trim(E.val() || ""),
		p = $.trim(( + w.val()) && w.find("option:selected").text() || ""),
		y = $.trim(( + s.val()) && s.find("option:selected").text() || ""),
		u = C.street_address || $.trim($("#street_address").val()),
		o = $.trim([r, p, y, u].join(" ")),
		D;
		r = r ? r + "市": "";
		x.empty().append(G);
		var B = C.coordinate || "";
		if (B == "0.0,0.0") {
			B = ""
		}
		var A = B.split(",");
		A = {
			lat: A[0],
			lng: A[1]
		};
		var n = u ? 15 : (y ? 14 : (p ? 12 : 10));
		var v = {
			zoom: n,
			width: "100%",
			height: "100%",
			panControl: true,
			mapTypeControl: true,
			scaleControl: false,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL
			},
			searchControl: false
		};
		if (B) {
			v.center = new google.maps.LatLng(A)
		}
		D = dui.iMap.createMap(G, v);
		var m = new google.maps.places.Autocomplete($("#q-address")[0], {
			type: "geocode"
		});
		m.bindTo("bounds", D);
		c(m, "place_changed",
		function() {
			var q = m.getPlace();
			var H;
			if (!q.geometry) {
				return
			}
			var H = q.geometry.location;
			if (!H) {
				return
			}
			D.setCenter(H);
			if (D.getZoom() < 12) {
				D.setZoom(15)
			}
			e.setPosition(H);
			k.node.find(".map-footer").html(i.replace("{coordinate}", H.toUrlValue()));
			g()
		});
		c(D, "zoom", l);
		c(D, "dragend", l);
		if ($("#sel-address-type1").length && $("#sel-address-type1")[0].checked) {
			z.val(u)
		} else {
			z.val("")
		}
		var F = C.full_address || o;
		if (A.lat) {
			h(D, {
				toLatLng: A
			},
			t)
		} else {
			if (C.full_address || y || u) {
				dui.iMap.search({
					ele: "#mapInner",
					map: D,
					address: F,
					success: function(I, q) {
						var H = q.geometry.location;
						h(I, {
							latLng: H,
							zoom: n
						},
						t);
						g()
					},
					fail: function(q) {
						h(q)
					}
				})
			} else {
				h(D)
			}
		}
		z.focus()
	}
	function g() {
		$("#map-tip").html("是否保存坐标到当前位置?  ");
		$("#map-btns").show()
	}
	function f(m) {
		var n = (m === "known_address") ? $("#selected_known_address").data() : {
			coordinate: $("#coordinate").val()
		};
		k.node.find(".bd").css({
			padding: 0
		});
		k.open();
		k.update();
		b(n, m)
	}
	$(document).delegate(".lnk-modify-addr", "click",
	function(m) {
		m.preventDefault();
		f($(this).data("type"))
	})
});