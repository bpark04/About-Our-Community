"use strict";

const residentCols = [
  "resident_name",
  "resident_sin",
  "city",
  "street",
  "house_number",
];
const drinkCols = ["drinkName", "price", "rating", "hotOrCold", "calories"];
const cafeCols = ["cafe_name", "rating"];

const SelectForm = () => {
  const [table, setTable] = React.useState("Drinks");

  console.log({ table });

  const handleTableChange = (event) => {
    setTable(event.target.value);
  };

  const showResidentsCols = table == "Resident";
  const showDrinksCols = table == "Drinks";
  const showCafeCols = table == "Cafe";

  return (
    <div>
      <h1>Select</h1>
      <h2>Choose what table you want to select from</h2>
      <form method="POST" action="index.php">
        <input
          type="hidden"
          id="selectQueryRequest"
          name="selectQueryRequest"
        />
        <select
          value={table}
          name="table_options"
          id="table_options"
          onChange={handleTableChange}
        >
          <option value="Drink">Drink</option>
          <option value="Resident">Resident</option>
          <option value="Cafe">Cafe</option>
        </select>

        <h2>Choose what attributes you want to select from the table </h2>

        {showResidentsCols &&
          residentCols.map((col) => {
            return (
              <div key={col}>
                <input type="checkbox" id="col" name="col[]" value={col} />
                {col}
              </div>
            );
          })}

        {showDrinksCols &&
          drinkCols.map((col) => {
            return (
              <div key={col}>
                <input type="checkbox" id="col" name="col[]" value={col} />
                {col}
              </div>
            );
          })}

        {showCafeCols &&
          cafeCols.map((col) => {
            return (
              <div key={col}>
                <input type="checkbox" id="col" name="col[]" value={col} />
                {col}
              </div>
            );
          })}

        <h2>Choose your filter</h2>
        <select name="col_filter_options" id="col_filter_options">
          {showResidentsCols &&
            residentCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}

          {showDrinksCols &&
            drinkCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}
          {showCafeCols &&
            cafeCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}
        </select>

        <select name="operator_options" id="operator_options">
          <option value="=">=</option>
          <option value=">">{">"}</option>
          <option value="<">{"<"}</option>
          <option value="<=">{"<="}</option>
          <option value=">=">{">="}</option>
        </select>

        <input type="text" name="selectUserInput" id="selectUserInput"></input>

        <br />

        <select name="col_filter_options2" id="col_filter_options2">
          {showResidentsCols &&
            residentCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}

          {showDrinksCols &&
            drinkCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}
          {showCafeCols &&
            cafeCols.map((col) => {
              return (
                <option key={col} value={col}>
                  {col}
                </option>
              );
            })}
        </select>

        <select name="operator_options2" id="operator_options2">
          <option value="=">=</option>
          <option value=">">{">"}</option>
          <option value="<">{"<"}</option>
          <option value="<=">{"<="}</option>
          <option value=">=">{">="}</option>
        </select>

        <input
          type="text"
          name="selectUserInput2"
          id="selectUserInput2"
        ></input>

        <div>
          <input type="submit" name="selectSubmit" />
        </div>
      </form>
    </div>
  );
};

const domContainer = document.querySelector("#like_button_container");
ReactDOM.render(React.createElement(SelectForm), domContainer);
