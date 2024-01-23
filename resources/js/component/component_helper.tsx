import React from 'react';

export function checkValueUndefineReturnString(value): string {
  if (typeof value === 'undefined') {
    return '';
  }
  if (value === 'undefined') {
    return '';
  }
  return value;
}
export function getCSRFToken() {
  return document.head.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}
export function getCookie(cookieName) {
  if (!document.cookie) {
    return null;
  }
  const xsrfCookies = document.cookie
    .split(';')
    .map(c => c.trim())
    .filter(c => c.startsWith((cookieName = '=')));
  if (xsrfCookies.length === 0) {
    return null;
  }
  return decodeURIComponent(xsrfCookies[0].split('=')[1]);
}

export function mustRequired(props) {
  if (props.required === true) {
    return '*';
  }
  return '';
}

export function setWithExpiry(key, value, ttl) {
  const now = new Date();
  const item = {
    value,
    expiry: now.getTime() + ttl,
  };
  localStorage.setItem(key, JSON.stringify(item));
}

export function getWithExpiry(key) {
  const itemStr = localStorage.getItem(key);
  if (!itemStr) {
    return null;
  }
  const item = JSON.parse(itemStr);
  const now = new Date();
  if (now.getTime() > item.expiry) {
    localStorage.removeItem(key);
    return null;
  }
  return item.value;
}

export const privacyNoticeUrl = '/datenschutz';
