const NumberFormat = new Intl.NumberFormat('de-DE', {
  style: 'currency',
  currency: 'EUR',
});

const convertNumber2Euro = (number: number): string => NumberFormat.format(number);

export default convertNumber2Euro;
