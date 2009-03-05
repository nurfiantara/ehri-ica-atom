// $Id$

Qubit.treeView = Qubit.treeView || {};

Drupal.behaviors.treeView = {
  attach: function (context)
    {
      function build(objects, expands, parentId, parentNode)
      {
        while (objects.length > 0 && objects[0].parentId == parentId)
        {
          var object = objects.shift();
          var textNode = new YAHOO.widget.TextNode(object, parentNode, expands[object.id] !== undefined);
          build(objects, expands, object.id, textNode);
        }
      }

      Qubit.treeView.treeView = new YAHOO.widget.TreeView('treeView');
      build(Qubit.treeView.objects, Qubit.treeView.expands, Qubit.treeView.objects[0].parentId, Qubit.treeView.treeView.getRoot());

      Qubit.treeView.treeView.draw();
    } };
