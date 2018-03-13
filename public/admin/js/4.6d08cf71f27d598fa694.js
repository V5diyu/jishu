webpackJsonp([4],{

/***/ 519:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(583)

var Component = __webpack_require__(202)(
  /* script */
  __webpack_require__(536),
  /* template */
  __webpack_require__(568),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 528:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__service_js__ = __webpack_require__(136);


/* harmony default export */ __webpack_exports__["a"] = ({
    host: 'http://p14vw1rbx.bkt.clouddn.com/',
    init: function (cb) {
        var uploader = Qiniu.uploader({
            runtimes: 'html5,flash,html4', // 上传模式，依次退化
            browse_button: 'btnupload', // 上传选择的点选按钮，必需
            // 在初始化时，uptoken，uptoken_url，uptoken_func三个参数中必须有一个被设置
            // 切如果提供了多个，其优先级为uptoken > uptoken_url > uptoken_func
            // 其中uptoken是直接提供上传凭证，uptoken_url是提供了获取上传凭证的地址，如果需要定制获取uptoken的过程则可以设置uptoken_func
            //uptoken: $scope.token, // uptoken是上传凭证，由其他程序生成
            uptoken_url: __WEBPACK_IMPORTED_MODULE_0__service_js__["a" /* default */].url('qiniu'), // Ajax请求uptoken的Url，强烈建议设置（服务端提供）
            uptoken_func: function (file) {
                // 在需要获取uptoken时，该方法会被调用
                // do something
                return uptoken;
            },
            get_new_uptoken: true, // 设置上传文件的时候是否每次都重新获取新的uptoken
            // downtoken_url: '/downtoken',
            // Ajax请求downToken的Url，私有空间时使用，JS-SDK将向该地址POST文件的key和domain，服务端返回的JSON必须包含url字段，url值为该文件的下载地址
            unique_names: true, // 默认false，key为文件名。若开启该选项，JS-SDK会为每个文件自动生成key（文件名）
            save_key: true, // 默认false。若在服务端生成uptoken的上传策略中指定了sava_key，则开启，SDK在前端将不对key进行任何处理
            domain: 'http://opz6k8mkh.bkt.clouddn.com/', // bucket域名，下载资源时用到，必需
            container: 'container', // 上传区域DOM ID，默认是browser_button的父元素
            max_file_size: '100mb', // 最大文件体积限制
            flash_swf_url: 'https://cdn.staticfile.org/plupload/2.1.9/Moxie.swf', //引入flash，相对路径
            max_retries: 3, // 上传失败最大重试次数
            dragdrop: true, // 开启可拖曳上传
            drop_element: 'container', // 拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
            chunk_size: '4mb', // 分块上传时，每块的体积
            auto_start: true, // 选择文件后自动上传，若关闭需要自己绑定事件触发上传
            //x_vars : {
            //    查看自定义变量
            //    'time' : function(up,file) {
            //        var time = (new Date()).getTime();
            // do something with 'time'
            //        return time;
            //    },
            //    'size' : function(up,file) {
            //        var size = file.size;
            // do something with 'size'
            //        return size;
            //    }
            //},
            init: {
                'FilesAdded': function (up, files) {},
                'BeforeUpload': function (up, file) {
                    // 每个文件上传前，处理相关的事情
                },
                'UploadProgress': function (up, file) {
                    // 每个文件上传时，处理相关的事情
                    console.log(up, file);
                },
                'FileUploaded': function (up, file, info) {
                    var info = JSON.parse(info);
                    cb && cb(info);
                    // self.form.img = info.data.url;
                },
                'Error': function (up, err, errTip) {
                    //上传出错时，处理相关的事情
                },
                'Key': function (up, file) {
                    // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                    // 该配置必须要在unique_names: false，save_key: false时才生效
                    var key = "";
                    // do something with key here
                    return key;
                }
            }
        });
    }
});

/***/ }),

/***/ 536:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__assets_qiniu_js__ = __webpack_require__(528);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    data() {
        return {
            keyword: '',
            tableData: [],
            loading: true,
            pn: 1,
            pageSize: 15,
            count: 0,

            classifyList: [],

            dialogVisible: false,
            dialogImgUrl: '',

            addDialogVisible: false,
            addDialogTitle: '添加文章',
            qiniuInitState: false,
            form: {
                classifyId: '',
                title: '',
                url: '',
                content: ''
            }
        };
    },
    created() {
        this.getData();

        this.getClassifyList();
    },
    methods: {
        updateData(val) {
            this.form.content = val;
        },
        getClassifyList() {
            this.$axios.post('getKnowledgeClassify', {}, res => {
                if (res.ret) {
                    this.classifyList = res.data.list;
                }
            });
        },
        dialogImg(url) {
            this.dialogImgUrl = url;
            this.dialogVisible = true;
        },
        handleCurrentChange(val) {
            this.pn = val;
            this.getData();
        },
        getData() {
            this.loading = true;
            this.$axios.post('getKnowledge', {
                title: this.keyword,
                pn: this.pn
            }, res => {
                if (res.ret == true) {
                    this.tableData = res.data.list;
                    this.count = res.data.count;
                    this.loading = false;
                }
            });
        },
        addDialog() {
            this.addDialogVisible = true;
            this.addDialogTitle = '添加文章';
            this.form = {
                classifyId: '',
                title: '',
                url: '',
                content: ''
            };

            if (!this.qiniuInitState) {
                this.qiniuInitState = true;
                this.$nextTick(() => {
                    __WEBPACK_IMPORTED_MODULE_0__assets_qiniu_js__["a" /* default */].init(info => {
                        this.form.url = info.data.url;
                    });
                });
            }
        },
        add() {
            let self = this;

            if (self.form.id) {
                this.$axios.post('updateKnowledge', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.addDialogVisible = false;
                        self.$message.success('修改成功');
                    }
                });
            } else {
                this.$axios.post('addKnowledge', self.form, res => {
                    if (res.ret == true) {
                        self.getData();
                        self.addDialogVisible = false;
                        self.$message.success('添加成功');
                    }
                });
            }
        },
        del(index, row) {
            this.$confirm('确定删除该文章?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$axios.post('delKnowledge', {
                    id: row.id
                }, res => {
                    this.$message.success('删除成功');
                    this.tableData.splice(index, 1);
                });
            }).catch(() => {
                this.$message.info('已取消删除');
            });
        },
        update(index, row) {
            this.addDialogVisible = true;
            this.addDialogTitle = '修改文章';
            this.form = row;

            if (!this.qiniuInitState) {
                this.qiniuInitState = true;
                this.$nextTick(() => {
                    __WEBPACK_IMPORTED_MODULE_0__assets_qiniu_js__["a" /* default */].init(info => {
                        this.form.url = info.data.url;
                    });
                });
            }
        }
    }
});

/***/ }),

/***/ 552:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(135)(undefined);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 568:
/***/ (function(module, exports) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "table"
  }, [_c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-breadcrumb', {
    attrs: {
      "separator": "/"
    }
  }, [_c('el-breadcrumb-item', [_c('i', {
    staticClass: "el-icon-menu"
  }), _vm._v("知识库")]), _vm._v(" "), _c('el-breadcrumb-item', [_vm._v("文章管理")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-input', {
    staticStyle: {
      "width": "200px"
    },
    attrs: {
      "placeholder": "请输入文章名称搜索",
      "prefix-icon": "el-icon-search"
    },
    nativeOn: {
      "keyup": function($event) {
        if (!('button' in $event) && _vm._k($event.keyCode, "enter", 13, $event.key)) { return null; }
        _vm.getData($event)
      }
    },
    model: {
      value: (_vm.keyword),
      callback: function($$v) {
        _vm.keyword = $$v
      },
      expression: "keyword"
    }
  })], 1), _vm._v(" "), _c('el-col', {
    attrs: {
      "span": 12
    }
  }, [_c('el-button', {
    staticStyle: {
      "float": "right"
    },
    attrs: {
      "type": "primary",
      "icon": "plus"
    },
    on: {
      "click": _vm.addDialog
    }
  }, [_vm._v("添加文章")])], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
    directives: [{
      name: "loading",
      rawName: "v-loading.body",
      value: (_vm.loading),
      expression: "loading",
      modifiers: {
        "body": true
      }
    }],
    staticStyle: {
      "width": "100%"
    },
    attrs: {
      "data": _vm.tableData,
      "border": ""
    }
  }, [_c('el-table-column', {
    attrs: {
      "prop": "id",
      "label": "ID",
      "width": "170"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "title",
      "label": "标题"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "图片",
      "width": "150"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('div', {
          staticClass: "avatarUrl",
          style: ({
            'background-image': 'url(' + scope.row.url + ')'
          }),
          on: {
            "click": function($event) {
              _vm.dialogImg(scope.row.url)
            }
          }
        })]
      }
    }])
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "classifyTxt",
      "label": "分类名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "180"
    },
    scopedSlots: _vm._u([{
      key: "default",
      fn: function(scope) {
        return [_c('el-button', {
          attrs: {
            "size": "small",
            "type": "success"
          },
          on: {
            "click": function($event) {
              _vm.update(scope.$index, scope.row)
            }
          }
        }, [_vm._v("修改")]), _vm._v(" "), _c('el-button', {
          attrs: {
            "size": "small",
            "type": "danger"
          },
          on: {
            "click": function($event) {
              _vm.del(scope.$index, scope.row)
            }
          }
        }, [_vm._v("删除")])]
      }
    }])
  })], 1), _vm._v(" "), _c('div', {
    staticClass: "pagination"
  }, [_c('el-pagination', {
    attrs: {
      "layout": "prev, pager, next",
      "total": _vm.count,
      "page-size": _vm.pageSize
    },
    on: {
      "current-change": _vm.handleCurrentChange
    }
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "visible": _vm.dialogVisible,
      "size": "large"
    },
    on: {
      "update:visible": function($event) {
        _vm.dialogVisible = $event
      }
    }
  }, [_c('img', {
    staticStyle: {
      "max-width": "100%"
    },
    attrs: {
      "src": _vm.dialogImgUrl
    }
  })]), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": _vm.addDialogTitle,
      "width": "80%",
      "visible": _vm.addDialogVisible
    },
    on: {
      "update:visible": function($event) {
        _vm.addDialogVisible = $event
      }
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.form,
      "label-width": "80px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "所属分类"
    }
  }, [_c('el-select', {
    attrs: {
      "placeholder": "请选择"
    },
    model: {
      value: (_vm.form.classifyId),
      callback: function($$v) {
        _vm.$set(_vm.form, "classifyId", $$v)
      },
      expression: "form.classifyId"
    }
  }, _vm._l((_vm.classifyList), function(item) {
    return _c('el-option', {
      key: item.id,
      attrs: {
        "label": item.name,
        "value": item.id
      }
    })
  }))], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "文章标题"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入文章标题"
    },
    model: {
      value: (_vm.form.title),
      callback: function($$v) {
        _vm.$set(_vm.form, "title", $$v)
      },
      expression: "form.title"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "文章图片"
    }
  }, [_c('div', {
    staticClass: "el-upload",
    attrs: {
      "id": "container"
    }
  }, [(_vm.form.url) ? _c('img', {
    staticClass: "avatar",
    attrs: {
      "src": _vm.form.url
    }
  }) : _c('i', {
    staticClass: "el-icon-plus avatar-uploader-icon"
  }), _vm._v(" "), _c('input', {
    staticClass: "upload-input",
    attrs: {
      "type": "file",
      "id": "btnupload",
      "name": "img"
    }
  })])]), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "文章内容"
    }
  }, [_c('vue-html5-editor', {
    attrs: {
      "content": _vm.form.content,
      "height": 300
    },
    on: {
      "change": _vm.updateData
    }
  })], 1)], 1), _vm._v(" "), _c('span', {
    staticClass: "dialog-footer",
    attrs: {
      "slot": "footer"
    },
    slot: "footer"
  }, [_c('el-button', {
    on: {
      "click": function($event) {
        _vm.addDialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.add
    }
  }, [_vm._v("确 定")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ }),

/***/ 583:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(552);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(203)("f956ac84", content, true);

/***/ })

});