webpackJsonp([12],{

/***/ 523:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(202)(
  /* script */
  __webpack_require__(540),
  /* template */
  __webpack_require__(572),
  /* scopeId */
  null,
  /* cssModules */
  null
)

module.exports = Component.exports


/***/ }),

/***/ 540:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
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

            curData: {},
            curIndex: '',
            updateDialogVisible: false,
            dialogTitle: '添加管理员'
        };
    },
    created() {
        this.getData();
    },
    methods: {
        getData() {
            this.loading = true;
            this.$axios.post('getAdmin', {
                account: this.keyword,
                pn: this.pn
            }, res => {
                this.tableData = res.data;
                this.loading = false;
            });
        },
        addDialog() {
            this.curData = {};
            this.updateDialogVisible = true;
        },
        del(index, row) {
            this.$confirm('删除管理员, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.$axios.post('deleteAdmin', {
                    id: row.id
                }, res => {
                    this.$message.success('删除成功');
                    this.tableData.splice(index, 1);
                });
            }).catch(() => {
                this.$message.info('已取消删除');
            });
        },
        updateDialog(index, row) {
            this.updateDialogVisible = true;
            this.curIndex = index;
            this.curData = row;
        },
        update() {
            if (this.curData.id) {
                this.$axios.post('updateAdmin', this.curData, res => {
                    this.$message.success('修改成功');
                    this.curIndex = '';
                    this.curData = {};
                    this.updateDialogVisible = false;
                });
            } else {
                this.$axios.post('addAdmin', this.curData, res => {
                    this.$message.success('添加成功');
                    this.curIndex = '';
                    this.curData = {};
                    this.getData();
                    this.updateDialogVisible = false;
                });
            }
        }
    }
});

/***/ }),

/***/ 572:
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
  }), _vm._v(" 管理员")])], 1)], 1)], 1), _vm._v(" "), _c('div', {
    staticClass: "crumbs"
  }, [_c('el-row', [_c('el-col', {
    attrs: {
      "span": 6
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入账号搜索",
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
      "span": 18
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
  }, [_vm._v("添加管理员")])], 1)], 1)], 1), _vm._v(" "), _c('el-table', {
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
      "label": "ID"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "name",
      "label": "管理员名称"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "account",
      "label": "管理员账号"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "prop": "create",
      "label": "创建时间"
    }
  }), _vm._v(" "), _c('el-table-column', {
    attrs: {
      "label": "操作",
      "width": "150"
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
              _vm.updateDialog(scope.$index, scope.row)
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
  })], 1), _vm._v(" "), _c('el-dialog', {
    attrs: {
      "title": _vm.dialogTitle,
      "visible": _vm.updateDialogVisible
    },
    on: {
      "update:visible": function($event) {
        _vm.updateDialogVisible = $event
      }
    }
  }, [_c('el-form', {
    ref: "form",
    attrs: {
      "model": _vm.curData,
      "label-width": "100px"
    }
  }, [_c('el-form-item', {
    attrs: {
      "label": "管理员名称"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入管理员名称"
    },
    model: {
      value: (_vm.curData.name),
      callback: function($$v) {
        _vm.$set(_vm.curData, "name", $$v)
      },
      expression: "curData.name"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "账号"
    }
  }, [_c('el-input', {
    attrs: {
      "placeholder": "请输入账号"
    },
    model: {
      value: (_vm.curData.account),
      callback: function($$v) {
        _vm.$set(_vm.curData, "account", $$v)
      },
      expression: "curData.account"
    }
  })], 1), _vm._v(" "), _c('el-form-item', {
    attrs: {
      "label": "密码"
    }
  }, [_c('el-input', {
    attrs: {
      "type": "password",
      "placeholder": "请输入密码"
    },
    model: {
      value: (_vm.curData.pwd),
      callback: function($$v) {
        _vm.$set(_vm.curData, "pwd", $$v)
      },
      expression: "curData.pwd"
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
        _vm.updateDialogVisible = false
      }
    }
  }, [_vm._v("取 消")]), _vm._v(" "), _c('el-button', {
    attrs: {
      "type": "primary"
    },
    on: {
      "click": _vm.update
    }
  }, [_vm._v("确 定")])], 1)], 1)], 1)
},staticRenderFns: []}

/***/ })

});