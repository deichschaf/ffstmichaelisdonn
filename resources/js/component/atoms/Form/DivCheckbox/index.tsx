import { useState } from 'react';
import { DivCheckboxProps } from '../../../../props/props';

const DivCheckbox: React.FC<React.PropsWithChildren<DivCheckboxProps>> = (
  props: DivCheckboxProps,
): JSX.Element => {
  const [checked, setChecked] = useState<boolean>(false);
  function setValue(checked) {
    setChecked(checked);
    props.setParentValue(checked);
  }
  return (
    <div className="checkbox check-success">
      <input
        id={props.id}
        type="checkbox"
        value={props.value}
        defaultChecked={checked}
        onChange={() => setValue(!checked)}
      />
      <label htmlFor={props.id}>{props.label}</label>
    </div>
  );
};
export default DivCheckbox;
