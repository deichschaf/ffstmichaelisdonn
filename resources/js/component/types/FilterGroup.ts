import SelectOption, { SelectButtonOption } from './SelectOption';

export default interface FilterGroup {
  active: (string | ReadonlyArray<string> | number)[];
  label: string;
  name: string;
  options: SelectOption[] | SelectButtonOption[];
  type: 'select' | 'multiselect';
}

export interface CheckboxFilterGroup {
  active: boolean;
  label: string;
  name: string;
  type: 'checkbox';
  value: 'on';
}

// eslint-disable-next-line
export function isCheckboxFilterGroup(arg: any): arg is CheckboxFilterGroup {
  return arg && arg.type && arg.type === 'checkbox';
}
