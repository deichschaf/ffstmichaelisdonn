import React from 'react';
import Select from 'react-select';
import { YearSelectorProps } from '../../../../../../props/props';
import ErrorBoundary from '../../../../errorboundary';

const YearSelector: React.FC<React.PropsWithChildren<YearSelectorProps>> = (
  props: YearSelectorProps,
): JSX.Element => {
  if (typeof props.years === 'undefined') {
    return <></>;
  }

  function setSelectedValue(year, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].label === year) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  function onChangeYear(e) {
    props.handleYear(e.value);
  }
  const options = [] as any;
  for (let i = 0; i < props.years.length; i += 1) {
    options.push({ label: props.years[i], value: props.years[i] });
  }

  return (
    <ErrorBoundary>
      <Select
        name="year"
        defaultValue={setSelectedValue(props.active, options)}
        options={options}
        className="basic-multi-select"
        onChange={e => onChangeYear(e)}
      />
    </ErrorBoundary>
  );
};
export default YearSelector;
