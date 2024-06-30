<?php
include 'sql_to_json_converter.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organization Chart</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .container {
      max-width: 800px;
      /* Adjust as needed */
    }

    .org-chart-container {
      width: 100%;
      height: 700px;
      /* Set initial height as needed */
      border: 1px solid #ccc;
    }

    .control-part-div {
      margin-bottom: 10px;
    }

    .input-field {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
  </style>
</head>

<body>
  <div class=" mt-4 d-flex justify-content-center">
    <div class="input-group mb-3 w-25">
      <input type="text" class="form-control" id="searchInput" placeholder="Enter ID to search">
      <div class="input-group-append mr-3">
        <button class="btn btn-primary" type="button" onclick="searchAndDisplay()">Search</button>
      </div>
    </div>

    <div class="control-part-div">
      <button class="button-33 btn btn-secondary" onclick="fitChart()">Fit Screen</button>
    </div>
  </div>

  <div class="org-chart-container" id="balkanApp"></div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="OrgChart.js"></script>
  <script>
    let data = <?php echo json_encode($arr); ?>;
    let chart = new OrgChart("#balkanApp", {
      nodeBinding: {
        field_0: "title",
        field_1: "id",
      },
      nodes: data,
      layout: OrgChart.tree,
      direction: "t2b", // Default direction, adjust as needed
      scaleInitial: true, // Automatically scale to fit container
      zoom: {
        level: 1 // Initial zoom level
      }
    });

    function searchAndDisplay() {
      let searchId = document.getElementById("searchInput").value;
      if (!searchId) return;

      let rootNode = data.find(node => node.id == searchId);

      if (rootNode) {
        let nodesToDisplay = findDescendants(data, searchId);
        nodesToDisplay.unshift(rootNode); // Add root node at the beginning
        chart.load(nodesToDisplay);
      } else {
        alert("ID not found");
      }
    }

    function findDescendants(nodes, parentId) {
      let result = [];
      let children = nodes.filter(node => node.parent_id == parentId);
      children.forEach(child => {
        result.push(child);
        let nestedChildren = findDescendants(nodes, child.id);
        result = result.concat(nestedChildren);
      });
      return result;
    }

    function fitChart() {
      chart.fit();
    }

    function compactLayout() {
      chart.config({
        layout: OrgChart.tree,
        direction: "t2b",
      });
      chart.fit();
    }
  </script>
</body>

</html>