# BravoView

`View` 层应该暴露尽可能少的API。模块化方面，仅暴露 `Component` 概念及子类 `Action`。

`Component` 之间的相互调用需要控制深度与循环。

`Component` 命名为 __NAMESPACE:NAME__，调用关系为：

    BravoView->Action->Pagelet->Component

接口函数统一为`load`，因此暂不支持`Pagelet`嵌套。