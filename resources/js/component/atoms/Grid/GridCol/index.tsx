import React from 'react';
import { GridColProps } from '../../../../props/props';

const GridCol: React.FC<React.PropsWithChildren<GridColProps>> = (
  props: GridColProps,
): JSX.Element => {
  function buildClass(props) {
    const classNames = [];
    classNames.push('column' as never);
    classNames.push('col' as never);
    if (typeof props.className !== 'undefined') {
      if (props.className !== '') {
        const val = props.className;
        classNames.push(val as never);
      }
    }
    if (typeof props.xxl !== 'undefined') {
      if (props.xxl !== '') {
        if (Number.isInteger(props.xxl)) {
          const val = `col-xxl-${props.xxl}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.xl !== 'undefined') {
      if (props.xl !== '') {
        if (Number.isInteger(props.xl)) {
          const val = `col-xl-${props.xl}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.lg !== 'undefined') {
      if (props.lg !== '') {
        if (Number.isInteger(props.lg)) {
          const val = `col-lg-${props.lg}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.md !== 'undefined') {
      if (props.md !== '') {
        if (Number.isInteger(props.md)) {
          const val = `col-md-${props.md}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.sm !== 'undefined') {
      if (props.sm !== '') {
        if (Number.isInteger(props.sm)) {
          const val = `col-sm-${props.sm}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.xs !== 'undefined') {
      if (props.xs !== '') {
        if (Number.isInteger(props.xs)) {
          const val = `col-xs-${props.xs}`;
          classNames.push(val as never);
        }
      }
    }
    if (typeof props.col !== 'undefined') {
      if (props.col !== '') {
        if (Number.isInteger(props.col)) {
          const val = `col-${props.col}`;
          classNames.push(val as never);
        }
      }
    }
    return classNames.join(' ');
  }
  return (
    <div id={props.id} key={props.key} className={buildClass(props)}>
      {props.children}
    </div>
  );
};
export default GridCol;
