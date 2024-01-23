import React, { useEffect, useState } from 'react';
import { ToggleSwitchProps } from '../../../../props/props';
import ErrorBoundary from '../../../organisms/errorboundary';

const ToggleSwitch: React.FC<React.PropsWithChildren<ToggleSwitchProps>> = (
  props: ToggleSwitchProps,
): JSX.Element => {
  const [isToggled, setIsToggled] = useState(false);
  const onToggle = () => {
    setIsToggled(!isToggled);
    props.parentCallback(!isToggled);
  };
  useEffect(() => {
    if (props.checked === true) {
      setIsToggled(true);
    }
  }, [props]);

  return (
    <ErrorBoundary>
      <div className="toggle-switch small-switch">
        <input
          onChange={onToggle}
          type="checkbox"
          className="toggle-switch-checkbox"
          name={props.name}
          id={props.name}
          checked={isToggled}
          value="1"
        />
        <label className="toggle-switch-label" htmlFor={props.name}>
          <span className="toggle-switch-inner" />
          <span className="toggle-switch-switch" />
        </label>
      </div>
    </ErrorBoundary>
  );
};

export default ToggleSwitch;
