export default interface ActiveFilter {
  label: string;
  name: string;
  value: string | ReadonlyArray<string> | number;
}
