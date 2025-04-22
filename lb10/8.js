const numbers = [2, 5, 8, 10, 3];

const result = numbers
  .map(num => num * 3)
  .filter(num => num > 10);

console.log(result);