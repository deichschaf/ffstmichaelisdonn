export default interface SelectOption {
  label: string;
  value: string | ReadonlyArray<string> | number;
}

export interface SelectButtonOption extends SelectOption {
  svg?: JSX.Element;
}
