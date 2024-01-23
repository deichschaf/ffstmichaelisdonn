import React from 'react';
import { isArray, isNumber, isObject, isString } from 'lodash';
import EmergencyListArray from './EmergencyListArray';
import EmergencyListEntry from './EmergencyListEntry';
import EmergencyListObject from './EmergencyListObject';

export function generateRandomNumber() {
  const array = new Uint32Array(1);
  window.crypto.getRandomValues(array);
  return array[0];
}

export function buildLi(value, idx, count) {
  if (typeof value === 'symbol') {
    return '';
  }
  if (value === null) {
    return '';
  }
  return (
    <li key={`${generateRandomNumber()}-${count}`}>
      {checkValueType(value, `${count}-${count}`) as any}
    </li>
  );
  // return <EmergencyListEntry key={idx} value={value} idx={idx} count={count} />;
}

function ListArray(value, count) {
  return (
    <ul key={`${generateRandomNumber()}-${count}`}>
      {value.map((item, idx) => buildLi(item, idx, count))}
    </ul>
  );
}
function ListObject(content, count) {
  // const keys = [];
  const values = [];
  // Object.keys(content).map((key, idx) => keys.push(key as never));
  Object.values(content).map((value, idx) => values.push(value as never));
  return (
    <ul key={`${generateRandomNumber()}-${count}`}>
      {values.map((item, idx) => buildLi(item, idx, count))}
    </ul>
  );
}

export function checkValueType(value, count) {
  if (value === null) {
    return value;
  }
  if (typeof value === 'undefined') {
    return '';
  }
  if (isArray(value)) {
    return ListArray(value, count);
  }
  // if (isObject(value)) {
  //   return ListObject(value, count);
  // }
  if (isString(value)) {
    return value;
  }
  if (isNumber(value)) {
    return value;
  }
  return '';
}
